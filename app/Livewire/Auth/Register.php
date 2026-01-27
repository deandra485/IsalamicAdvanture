<?php
namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

#[Layout('layouts.guest')]
class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $no_telepon = '';
    public $alamat = '';
    public $recaptcha_token = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'recaptcha_token' => 'required',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'recaptcha_token.required' => 'Silakan verifikasi bahwa Anda bukan robot.',
    ];

    public function register()
    {
        // Validasi basic dulu
        $validated = $this->validate();

        // Verifikasi reCAPTCHA
        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $this->recaptcha_token,
                'remoteip' => request()->ip()
            ]);

            $result = $response->json();

            // Debug: Log hasil verifikasi (hapus setelah testing)
            Log::info('reCAPTCHA verification result:', $result);

            if (!isset($result['success']) || !$result['success']) {
                $errorCodes = $result['error-codes'] ?? ['unknown-error'];
                
                $this->addError('recaptcha_token', 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
                
                // Log error untuk debugging
                Log::error('reCAPTCHA verification failed:', [
                    'error_codes' => $errorCodes,
                    'token' => $this->recaptcha_token,
                    'result' => $result
                ]);
                
                return;
            }

        } catch (\Exception $e) {
            $this->addError('recaptcha_token', 'Terjadi kesalahan saat verifikasi. Silakan coba lagi.');
            Log::error('reCAPTCHA exception:', ['message' => $e->getMessage()]);
            return;
        }

        // Jika reCAPTCHA valid, buat user
        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'no_telepon' => $this->no_telepon,
                'alamat' => $this->alamat,
                'role' => 'customer',
                'is_active' => true,
            ]);

            Auth::login($user);

            session()->flash('success', 'Registrasi berhasil! Selamat datang di IslamicAdvanture.');
            return redirect()->route('home');

        } catch (\Exception $e) {
            $this->addError('email', 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.');
            Log::error('User creation failed:', ['message' => $e->getMessage()]);
            return;
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}