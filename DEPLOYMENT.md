# 🚀 Panduan Deploy IslamicAdvanture ke Production

## 🗺️ Pilihan Platform Hosting

| Platform | Harga | Cocok untuk | Rekomendasi |
|---|---|---|---|
| **VPS (Niagahoster/IDCloudHost)** | Rp 50-150rb/bln | Pemula | ⭐ Termudah |
| **Google Cloud Run** | Pay-as-you-go | Scalable | ⭐⭐ Menengah |
| **Google Compute Engine** | ~$10-20/bln | Full control | ⭐⭐⭐ Advanced |

---

## 📋 Checklist Sebelum Deploy

### 1️⃣ Setup Variabel ENV yang WAJIB diisi

Buka file `.env` di server production dan isi semua yang bertanda `←`:

```env
APP_NAME="IslamicAdvanture"
APP_ENV=production
APP_DEBUG=false                         # ← WAJIB false di production!
APP_URL=https://namadomain-kamu.com     # ← domain asli kamu

DB_HOST=...                             # ← IP server database
DB_USERNAME=...                         # ← username MySQL
DB_PASSWORD=...                         # ← password MySQL

GOOGLE_CLIENT_ID=...                    # ← dari Google Console
GOOGLE_CLIENT_SECRET=...               # ← dari Google Console
GOOGLE_REDIRECT_URL=https://namadomain-kamu.com/auth/google/callback

MIDTRANS_SERVER_KEY=...                 # ← dari Midtrans Dashboard
MIDTRANS_CLIENT_KEY=...                 # ← dari Midtrans Dashboard
MIDTRANS_IS_PRODUCTION=true            # ← true saat live!

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-kamu@gmail.com
MAIL_PASSWORD=xxxx-xxxx-xxxx-xxxx       # ← Gmail App Password
MAIL_FROM_ADDRESS="no-reply@namadomain-kamu.com"
```

---

### 2️⃣ Cara Dapat Google Client ID & Secret

1. Buka → **https://console.cloud.google.com**
2. Buat project baru atau pilih project yang ada
3. Pergi ke **APIs & Services → Credentials**
4. Klik **"+ Create Credentials" → OAuth Client ID**
5. Application type: **Web Application**
6. Tambahkan **Authorized redirect URIs**:
   ```
   https://namadomain-kamu.com/auth/google/callback
   ```
7. Klik **Create** → copy **Client ID** dan **Client Secret** ke `.env`

> ⚠️ Jangan lupa aktifkan **Google+ API** atau **People API** di library!

---

### 3️⃣ Cara Dapat Midtrans Keys

1. Buka → **https://dashboard.midtrans.com**
2. Login / daftar akun
3. Pergi ke **Settings → Access Keys**
4. Copy **Server Key** dan **Client Key**
5. Untuk production, pastikan pindah ke **Production mode** (bukan Sandbox)

---

### 4️⃣ Gmail App Password (untuk kirim email)

1. Buka akun Google kamu
2. Pergi ke **Manage Account → Security → 2-Step Verification** (aktifkan dulu)
3. Setelah aktif, cari **"App passwords"**
4. Buat app password untuk "Mail" → "Other" → tulis "IslamicAdvanture"
5. Copy password 16 digit → masukkan ke `MAIL_PASSWORD` di `.env`

---

## 🖥️ Cara Deploy ke VPS (Paling Mudah)

### Langkah-langkah di server:

```bash
# 1. Upload project (via Git atau FTP)
git clone https://github.com/username/IsalamicAdvanture.git /var/www/islamicadvanture
cd /var/www/islamicadvanture

# 2. Install dependencies
composer install --no-dev --optimize-autoloader

# 3. Copy dan isi .env
cp .env.example .env
nano .env   # ← isi semua nilai yang dibutuhkan

# 4. Generate app key
php artisan key:generate

# 5. Jalankan migrasi database
php artisan migrate --force

# 6. Build assets
npm install && npm run build

# 7. Optimasi untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 8. Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 9. Buat symlink storage (untuk upload file)
php artisan storage:link
```

---

## ☁️ Cara Deploy ke Google Cloud Run

### Buat Dockerfile di root project:

```dockerfile
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx curl zip unzip git libpng-dev libjpeg-dev \
    libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html
WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
```

```bash
# Build dan push ke Google Container Registry
gcloud builds submit --tag gcr.io/PROJECT-ID/islamicadvanture

# Deploy ke Cloud Run
gcloud run deploy islamicadvanture \
  --image gcr.io/PROJECT-ID/islamicadvanture \
  --platform managed \
  --region asia-southeast2 \
  --allow-unauthenticated \
  --set-env-vars APP_ENV=production,APP_DEBUG=false
```

---

## 🔍 Cek Setelah Deploy

- [ ] `APP_DEBUG=false` ✅
- [ ] `APP_ENV=production` ✅  
- [ ] Login Google OAuth berfungsi ✅
- [ ] Upload foto/bukti pembayaran berfungsi (`php artisan storage:link`) ✅
- [ ] Email notifikasi terkirim ✅
- [ ] Midtrans payment berfungsi ✅
- [ ] HTTPS aktif (SSL) ✅

---

## ⚠️ Yang JANGAN dilupakan

```bash
# Jangan lupa hapus file debug setelah deploy:
php artisan optimize:clear   # hapus cache lama
php artisan optimize          # rebuild cache production

# Jalankan queue worker (untuk notifikasi email):
php artisan queue:work --daemon
# atau tambahkan ke Supervisor/cron
```
