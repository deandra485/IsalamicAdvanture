#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
IslamicAdventure FTP Deployer v3
Jalankan: python3 deploy.py
Setup   : Isi deploy.config.ini terlebih dahulu
"""

import ftplib
import os
import sys
import time
import json
import subprocess
import configparser
from pathlib import Path
from datetime import datetime

# ─── Warna terminal ───────────────────────────────────────
class C:
    RESET  = "\033[0m"
    BOLD   = "\033[1m"
    GREEN  = "\033[92m"
    YELLOW = "\033[93m"
    RED    = "\033[91m"
    CYAN   = "\033[96m"
    BLUE   = "\033[94m"
    GRAY   = "\033[90m"

def ok(msg):   print(f"  [OK]  {C.GREEN}{msg}{C.RESET}")
def warn(msg): print(f"  [!!]  {C.YELLOW}{msg}{C.RESET}")
def err(msg):  print(f"  [XX]  {C.RED}{msg}{C.RESET}")
def info(msg): print(f"  [>>]  {msg}")
def step(msg): print(f"\n{C.BOLD}{C.BLUE}=== {msg} ==={C.RESET}")
def dim(msg):  print(f"        {C.GRAY}{msg}{C.RESET}")

BASE_DIR    = Path(__file__).parent.resolve()
CONFIG_FILE = BASE_DIR / "deploy.config.ini"
MANIFEST    = BASE_DIR / ".deploy_manifest.json"

# ─── Folder / file yang TIDAK diupload ────────────────────
SKIP_DIRS = {
    "node_modules", ".git", ".github", "tests",
    ".idea", ".vscode", "__pycache__",
    "vendor",          # install di server via composer
}

SKIP_DIR_PATHS = {
    "storage/logs",
    "storage/framework/cache",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/app/livewire-tmp",
    "bootstrap/cache",          # cache lokal berisi path lokal -> JANGAN upload
}

# Folder yang WAJIB ada di server (dibuat kalau belum ada, isinya tetap skip).
REQUIRED_DIRS = [
    "bootstrap/cache",
    "storage/app/public",
    "storage/app/livewire-tmp",
    "storage/framework/cache/data",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/logs",
]

SKIP_FILES = {
    ".env", ".env.local", ".env.development",
    ".gitignore", ".gitattributes",
    "deploy.py", "deploy.config.ini",
    "package-lock.json", "yarn.lock",
    "phpunit.xml", ".editorconfig",
    ".phpunit.result.cache", "DEPLOYMENT.md",
    "README.md", "Makefile", ".deploy_manifest.json",
}

SKIP_EXTS = {".log", ".sqlite", ".DS_Store", ".Thumbs.db"}

# ─── Baca konfigurasi ─────────────────────────────────────
def load_config():
    if not CONFIG_FILE.exists():
        err(f"File tidak ditemukan: {CONFIG_FILE.name}")
        warn("Buat file deploy.config.ini terlebih dahulu!")
        sys.exit(1)

    cfg = configparser.ConfigParser()
    cfg.read(str(CONFIG_FILE), encoding="utf-8")

    # Cek field wajib
    for section, key in [("ftp","host"),("ftp","user"),("ftp","pass"),("ftp","remote")]:
        if not cfg.has_option(section, key) or not cfg.get(section, key).strip():
            err(f"Konfigurasi [{section}] {key} kosong di deploy.config.ini")
            sys.exit(1)

    # Cek masih pakai nilai default
    placeholder_hosts = {"ftp.namadomain.com", "namadomain.com"}
    placeholder_users = {"cpanel_username", "username_cpanel", "ftp@namadomain.com"}
    if cfg.get("ftp","host") in placeholder_hosts or cfg.get("ftp","user") in placeholder_users:
        err("Konfigurasi masih menggunakan nilai placeholder!")
        warn("Isi deploy.config.ini dengan data hosting asli kamu.")
        sys.exit(1)

    return {
        "host":     cfg.get("ftp", "host").strip(),
        "user":     cfg.get("ftp", "user").strip(),
        "pass":     cfg.get("ftp", "pass").strip(),
        "port":     cfg.getint("ftp", "port", fallback=21),
        "remote":   cfg.get("ftp", "remote").strip().rstrip("/") or "/",
        "build":    cfg.getboolean("options", "build_before_upload",    fallback=True),
        "optimize": cfg.getboolean("options", "optimize_before_upload", fallback=True),
        "retries":  cfg.getint("options", "max_retries", fallback=3),
        "passive":  cfg.getboolean("options", "passive", fallback=True),
        "timeout":  cfg.getint("options", "timeout", fallback=60),
    }

# ─── Progress bar ─────────────────────────────────────────
def progress_bar(current, total, label="", width=40):
    pct    = current / total if total else 0
    filled = int(width * pct)
    bar    = "#" * filled + "-" * (width - filled)
    label  = str(label)[:38].ljust(38)
    sys.stdout.write(f"\r  [{bar}] {pct*100:5.1f}%  {C.GRAY}{label}{C.RESET}")
    sys.stdout.flush()
    if current >= total:
        print()

# ─── Scan file ────────────────────────────────────────────
def should_skip(rel: Path) -> bool:
    parts = rel.parts
    for part in parts[:-1]:
        if part in SKIP_DIRS:
            return True
    for sp in SKIP_DIR_PATHS:
        sk = tuple(sp.split("/"))
        if parts[:len(sk)] == sk:
            return True
    if parts[-1] in SKIP_FILES:
        return True
    if Path(parts[-1]).suffix.lower() in SKIP_EXTS:
        return True
    return False

def collect_files(src: Path):
    files = []
    for p in src.rglob("*"):
        if p.is_file():
            rel = p.relative_to(src)
            if not should_skip(rel):
                files.append((p, rel))
    files.sort(key=lambda x: str(x[1]))
    return files

def fmt_size(b):
    for u in ["B","KB","MB","GB"]:
        if b < 1024: return f"{b:.1f} {u}"
        b /= 1024
    return f"{b:.1f} GB"

# ─── Manifest (deteksi file berubah) ──────────────────────
def file_sig(p: Path):
    st = p.stat()
    return {"size": st.st_size, "mtime": int(st.st_mtime)}

def load_manifest(cfg):
    if not MANIFEST.exists():
        return {}
    try:
        data = json.loads(MANIFEST.read_text(encoding="utf-8"))
    except Exception:
        return {}
    if data.get("host") != cfg["host"] or data.get("remote") != cfg["remote"]:
        return {}
    return data.get("files", {})

def save_manifest(cfg, files_map):
    data = {
        "version": 1,
        "host": cfg["host"],
        "remote": cfg["remote"],
        "updated": datetime.now().isoformat(timespec="seconds"),
        "files": files_map,
    }
    MANIFEST.write_text(json.dumps(data, indent=1), encoding="utf-8")

def ftp_connect(cfg, retries=None):
    retries = retries or cfg.get("retries", 3)
    timeout = cfg.get("timeout", 60)
    last = None
    for attempt in range(1, retries + 1):
        try:
            ftp = ftplib.FTP()
            ftp.connect(cfg["host"], cfg["port"], timeout=timeout)
            try:
                ftp.login(cfg["user"], cfg["pass"])
            except ftplib.error_perm as e:
                raise RuntimeError(f"Login ditolak server: {e}") from e
            ftp.set_pasv(cfg["passive"])
            return ftp
        except Exception as e:
            last = e
            if attempt < retries:
                warn(f"Koneksi gagal (percobaan {attempt}/{retries}): {e}")
                time.sleep(2 * attempt)
    raise last

def ftp_verify_channel(ftp, cfg):
    try:
        ftp.nlst()
    except Exception as first:
        if cfg["passive"]:
            warn("Mode passive gagal, beralih ke mode active...")
            ftp.set_pasv(False)
            try:
                ftp.nlst()
                cfg["passive"] = False
                return
            except Exception as second:
                raise RuntimeError(
                    f"Data channel gagal (passive & active): {second}"
                ) from second
        raise

def remote_join(base, rel):
    return base.rstrip("/") + "/" + rel.replace(os.sep, "/").lstrip("/")

def ftp_resolve_base(ftp, cfg):
    base = cfg["remote"]
    if base in ("", "/"):
        return "/"
    try:
        ftp.cwd(base)
        ftp.cwd("/")
        return base
    except ftplib.error_perm:
        warn(f"Path '{base}' tidak ditemukan di akun FTP.")
        warn("Akun FTP DirectAdmin di-chroot ke folder domain (root '/').")
        warn("Memakai root FTP '/' sebagai target upload.")
        return "/"

def ftp_conn_dead(e):
    """True kalau koneksi rusak (timeout/putus), bukan balasan 5xx dari server."""
    return isinstance(e, (OSError, EOFError))

def ftp_mkdirs(ftp, path):
    parts = [p for p in path.replace("\\", "/").split("/") if p]
    cur = ""
    for p in parts:
        cur += "/" + p
        try:
            ftp.mkd(cur)
        except ftplib.error_perm:
            pass
        except ftplib.all_errors as e:
            if ftp_conn_dead(e):
                raise

def remote_ensure_dirs(ftp, base):
    # Pastikan folder storage/bootstrap wajib ada di server. Isinya memang
    # di-skip, tapi foldernya harus ada atau Laravel error
    # "Please provide a valid cache path."
    for d in REQUIRED_DIRS:
        ftp_mkdirs(ftp, remote_join(base, d))

def ftp_upload(ftp, local: Path, remote: str, retries=3):
    rdir = "/".join(remote.replace("\\","/").split("/")[:-1])
    if rdir:
        ftp_mkdirs(ftp, rdir)
    last_err = None
    for i in range(retries):
        try:
            with open(local, "rb") as f:
                ftp.storbinary(f"STOR {remote}", f)
            return
        except ftplib.all_errors as e:
            last_err = e
            # Socket sudah "poisoned" oleh timeout -> retry di koneksi yang
            # sama pasti gagal. Lempar sekarang biar caller bikin koneksi baru.
            if ftp_conn_dead(e):
                raise
            if i < retries - 1:
                time.sleep(1.5 * (i + 1))
    raise last_err

# ─── Build & optimize ─────────────────────────────────────
def run_build():
    step("Build Vite Assets")
    info("npm run build ...")
    r = subprocess.run(["npm","run","build"], cwd=str(BASE_DIR),
                       capture_output=True, text=True)
    if r.returncode != 0:
        err("npm run build GAGAL!")
        print(r.stderr[-1000:])
        return False
    ok("Build selesai  (public/build/)")
    return True

def run_optimize():
    step("Bersihkan cache lokal")
    # JANGAN config:cache / route:cache / view:cache di lokal: cache-nya
    # menyimpan path absolut lokal (mis. /home/user/...) dan kalau ter-upload
    # bikin server error "open_basedir restriction". Cukup bersihkan di sini;
    # cache produksi di-generate di server (lihat instruksi akhir).
    r = subprocess.run(["php","artisan","optimize:clear"], cwd=str(BASE_DIR),
                       capture_output=True, text=True)
    if r.returncode == 0:
        ok("Cache lokal dibersihkan (optimize:clear)")
    else:
        warn("optimize:clear dilewati")

# ─── Upload ───────────────────────────────────────────────
def run_upload(cfg, src: Path = None, incremental=False):
    step("Upload via FTP" + (" — hanya yang berubah" if incremental else " — semua file"))
    src = src or BASE_DIR

    info("Mengumpulkan file...")
    all_files = collect_files(src)
    old_manifest = load_manifest(cfg) if incremental else {}

    entries = []
    skipped = 0
    for lpath, rel in all_files:
        key  = str(rel).replace(os.sep, "/")
        sig  = file_sig(lpath)
        if incremental and old_manifest.get(key) == sig:
            skipped += 1
            continue
        entries.append((lpath, rel, key, sig))

    total = len(entries)
    size  = sum(e[0].stat().st_size for e in entries)

    info(f"Lokal  : {len(all_files):,} file")
    if incremental:
        info(f"Berubah: {total:,} file  (dilewati {skipped:,} tidak berubah)")
    dim(f"Ukuran : {fmt_size(size)}")
    dim(f"Sumber : {src}")
    dim(f"Target : ftp://{cfg['host']}{cfg['remote']}")

    if total == 0:
        print()
        if incremental:
            local_keys = {str(rel).replace(os.sep, "/") for _, rel in all_files}
            save_manifest(cfg, {k: v for k, v in old_manifest.items() if k in local_keys})
        ok("Tidak ada file baru/berubah. Selesai, tidak ada yang diupload.")
        return True

    print()
    ans = input(f"  {C.BOLD}{C.YELLOW}Mulai upload {total:,} file? (y/N): {C.RESET}").strip().lower()
    if ans != "y":
        warn("Dibatalkan.")
        return False

    print()
    info(f"Connecting {cfg['host']}:{cfg['port']} ...")
    try:
        ftp = ftp_connect(cfg)
        ftp_verify_channel(ftp, cfg)
        base = ftp_resolve_base(ftp, cfg)
        ok(f"Terhubung! ({ftp.getwelcome().splitlines()[0][:60]})")
        dim(f"Base   : {base}")
        remote_ensure_dirs(ftp, base)
    except Exception as e:
        err(f"Koneksi gagal: {e}")
        err("Tips: cek host, user, password, dan pastikan port 21 terbuka")
        return False

    start    = time.time()
    uploaded = 0
    failed   = []
    reconn   = 0
    new_manifest = dict(old_manifest)

    def reconnect():
        nonlocal ftp, base, reconn
        try:
            ftp.quit()
        except Exception:
            pass
        ftp = ftp_connect(cfg)
        base = ftp_resolve_base(ftp, cfg)
        reconn += 1

    print()
    for i, (lpath, rel, key, sig) in enumerate(entries, 1):
        progress_bar(i, total, str(rel))
        try:
            ftp_upload(ftp, lpath, remote_join(base, key), cfg["retries"])
            uploaded += 1
            new_manifest[key] = sig
        except ftplib.all_errors as e:
            # Koneksi rusak / socket timeout -> buat koneksi baru, coba lagi.
            try:
                warn(f"\n  Koneksi terputus ({e}) — menyambung ulang ...")
                reconnect()
                ftp_upload(ftp, lpath, remote_join(base, key), cfg["retries"])
                uploaded += 1
                new_manifest[key] = sig
            except Exception as e2:
                failed.append((str(rel), str(e2)))
        except Exception as e:
            failed.append((str(rel), str(e)))

    try: ftp.quit()
    except: pass

    local_keys   = {str(rel).replace(os.sep, "/") for _, rel in all_files}
    new_manifest = {k: v for k, v in new_manifest.items() if k in local_keys}
    save_manifest(cfg, new_manifest)

    elapsed = time.time() - start
    speed   = size / elapsed / 1024 if elapsed else 0

    print()
    step("Hasil")
    ok(f"Berhasil : {uploaded:,}/{total:,} file")
    if incremental:
        ok(f"Dilewati : {skipped:,} file (tidak berubah)")
    if reconn:
        warn(f"Sambung ulang: {reconn}x (koneksi sempat terputus)")
    ok(f"Waktu    : {elapsed:.1f} detik  (~{speed:.0f} KB/s)")
    dim(f"Manifest : {MANIFEST.name}")

    if failed:
        print()
        warn(f"Gagal    : {len(failed)} file")
        for fn, reason in failed[:10]:
            err(f"  {fn}")
            dim(f"    => {reason}")
        log = BASE_DIR / "deploy_errors.log"
        with open(log, "w") as f:
            f.write(f"Error log {datetime.now()}\nHost: {cfg['host']}\n\n")
            for fn, reason in failed:
                f.write(f"FAILED: {fn}\n  {reason}\n\n")
        info(f"Log tersimpan: {log.name}")

    return len(failed) == 0

# ─── Info setelah deploy ──────────────────────────────────
def post_info(cfg):
    step("Langkah Setelah Deploy")
    remote_path = cfg["remote"]
    print(f"""
  Jalankan via SSH di server DirectAdmin:

  {C.CYAN}cd {remote_path}{C.RESET}
  {C.CYAN}composer install --no-dev --optimize-autoloader{C.RESET}
  {C.CYAN}php artisan migrate --force{C.RESET}
  {C.CYAN}php artisan storage:link{C.RESET}
  {C.CYAN}php artisan optimize{C.RESET}
  {C.CYAN}chmod -R 755 storage bootstrap/cache{C.RESET}

  Juga upload file {C.YELLOW}.env production{C.RESET} ke folder root project di server!
  (JANGAN pakai .env lokal yang ada password database lokal!)
    """)

# ─── Menu utama ───────────────────────────────────────────
def main():
    print(f"""
{C.BOLD}{C.CYAN}  ======================================
  IslamicAdventure — FTP Deployer v3
  {datetime.now().strftime("%d %B %Y  %H:%M")}
  ======================================{C.RESET}
""")

    cfg = load_config()
    ok(f"Konfigurasi OK: deploy.config.ini")
    dim(f"Host   : {cfg['host']}:{cfg['port']}")
    dim(f"User   : {cfg['user']}")
    dim(f"Remote : {cfg['remote']}")

    print(f"""
  {C.BOLD}Pilih mode:{C.RESET}

  [1]  Full deploy    (build + optimize + upload SEMUA file)
  [2]  Deploy cepat   (build + optimize + upload yang BERUBAH saja)
  [3]  Upload semua   (skip build, upload SEMUA file)
  [4]  Upload berubah (skip build, upload yang BERUBAH saja)
  [5]  Upload satu folder saja
  [6]  Hanya build assets
  [0]  Keluar

  {C.GRAY}Mode 2 & 4 pakai {MANIFEST.name} untuk deteksi file berubah.{C.RESET}
""")

    choice = input(f"  {C.BOLD}Pilihan: {C.RESET}").strip()

    if choice == "0":
        print("  Keluar.")
        sys.exit(0)

    elif choice == "1":
        if cfg["build"] and not run_build():
            err("Build gagal, deploy dibatalkan.")
            sys.exit(1)
        if cfg["optimize"]:
            run_optimize()
        success = run_upload(cfg, incremental=False)

    elif choice == "2":
        if cfg["build"] and not run_build():
            err("Build gagal, deploy dibatalkan.")
            sys.exit(1)
        if cfg["optimize"]:
            run_optimize()
        success = run_upload(cfg, incremental=True)

    elif choice == "3":
        success = run_upload(cfg, incremental=False)

    elif choice == "4":
        success = run_upload(cfg, incremental=True)

    elif choice == "5":
        folder = input(f"  {C.BOLD}Folder (contoh: public/build): {C.RESET}").strip()
        src = BASE_DIR / folder
        if not src.exists():
            err(f"Folder tidak ada: {src}")
            sys.exit(1)
        success = run_upload(cfg, src)

    elif choice == "6":
        success = run_build()

    else:
        err("Pilihan tidak valid.")
        sys.exit(1)

    if choice in ("1","2","3","4","5"):
        post_info(cfg)
        if success:
            print(f"  {C.GREEN}{C.BOLD}Deploy berhasil!{C.RESET}\n")
        else:
            print(f"  {C.YELLOW}Deploy selesai dengan beberapa error. Cek deploy_errors.log{C.RESET}\n")


if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print(f"\n\n  {C.YELLOW}Deploy dibatalkan.{C.RESET}\n")
        sys.exit(0)
