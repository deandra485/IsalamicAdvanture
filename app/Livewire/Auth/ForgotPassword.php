<?php
// app/Livewire/Auth/ForgotPassword.php
namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Password;

#[layout('layouts.guest')]
class ForgotPassword extends Component
{
    public $email = '';

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    protected $messages = [
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.exists' => 'Email tidak terdaftar',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Link reset password telah dikirim ke email Anda!');
            $this->email = '';
        } else {
            $this->addError('email', 'Gagal mengirim link reset password.');
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
