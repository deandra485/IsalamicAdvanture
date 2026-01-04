<?php
// ==========================================
// APP/LIVEWIRE/USER/PROFILE.PHP
// ==========================================

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Traits\HasFileUpload;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


#[layout('layouts.app')]
class Profile extends Component
{
    use WithFileUploads, HasFileUpload;

    // Profile Info
    public $name;
    public $email;
    public $no_telepon;
    public $alamat;
    public $avatar;
    public $existingAvatar;
    public User $user;


    // Password Change
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // UI State
    public $activeTab = 'profile'; // profile, password

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048', // 2MB max
        ];
    }

    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah digunakan',
        'avatar.image' => 'File harus berupa gambar',
        'avatar.max' => 'Ukuran gambar maksimal 2MB',
    ];

    public function mount()
    {
        $this->user = Auth::user();

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->no_telepon = $this->user->no_telepon;
        $this->alamat = $this->user->alamat;
        $this->existingAvatar = $user->avatar ?? null;
    }

    public function updateProfile()
    {
        $this->validate();

        try {
           $user = $this->user;
            
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'no_telepon' => $this->no_telepon,
                'alamat' => $this->alamat,
            ];

            // Handle avatar upload
            if ($this->avatar) {
                // Delete old avatar if exists
                if ($user->avatar) {
                    $this->deleteImage($user->avatar);
                }
                
                // Upload new avatar
                $path = $this->uploadImage($this->avatar, 'avatars');
                $data['avatar'] = $path;
                $this->existingAvatar = $path;
            }

            $user->update($data);

            // Log activity
            \App\Models\ActivityLog::log(
                'update',
                'users',
                $user->id,
                'User updated profile'
            );

            $this->reset('avatar');
            session()->flash('success', 'Profile berhasil diupdate!');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function removeAvatar()
    {
        try {
           $user = $this->user;
            
            if ($user->avatar) {
                $this->deleteImage($user->avatar);
                $user->update(['avatar' => null]);
                $this->existingAvatar = null;
                
                session()->flash('success', 'Avatar berhasil dihapus!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus avatar.');
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if (!Hash::check($this->current_password,  $this->user->password)) {
            $this->addError('current_password', 'Password saat ini salah.');
            return;
        }

        try {
            $this->user->update([
                'password' => Hash::make($this->new_password),
            ]);

            // Log activity
            \App\Models\ActivityLog::log(
                'update',
                'users',
                $this->user->id,
                'User changed password'
            );

            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
            session()->flash('password_success', 'Password berhasil diubah!');

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengubah password.');
        }
    }

    public function render()
    {
        return view('livewire.user.profile');
    }
}