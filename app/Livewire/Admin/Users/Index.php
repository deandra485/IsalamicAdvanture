<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = ''; // admin, customer, or empty for all

    // State untuk Modal Booking History
    public $showBookingModal = false;
    public $selectedUser = null;

    // State untuk Modal Reset Password
    public $showPasswordModal = false;
    public $resetUserId = null;
    public $newPassword = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // 1. Toggle Active/Inactive
    public function toggleStatus($id)
    {
        $user = User::find($id);
        if ($user && $user->id !== auth()->id()) { // Prevent self-deactivation
            $user->update(['is_active' => !$user->is_active]);
            session()->flash('success', 'User status updated successfully.');
        }
    }

    // 2. Change Role (Admin <-> Customer)
    public function updateRole($id, $newRole)
    {
        $user = User::find($id);
        if ($user && in_array($newRole, ['admin', 'customer'])) {
            $user->update(['role' => $newRole]);
            session()->flash('success', "User role changed to {$newRole}.");
        }
    }

    // 3. View Booking History
    public function viewHistory($id)
    {
        $this->selectedUser = User::with(['bookings.mountain'])->find($id);
        $this->showBookingModal = true;
    }

    public function closeBookingModal()
    {
        $this->showBookingModal = false;
        $this->selectedUser = null;
    }

    // 4. Reset Password
    public function openPasswordModal($id)
    {
        $this->resetUserId = $id;
        $this->newPassword = '';
        $this->showPasswordModal = true;
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:6',
        ]);

        $user = User::find($this->resetUserId);
        if ($user) {
            $user->update([
                'password' => Hash::make($this->newPassword)
            ]);
            session()->flash('success', 'Password reset successfully.');
            $this->showPasswordModal = false;
            $this->resetUserId = null;
            $this->newPassword = '';
        }
    }

    public function render()
    {
        $users = User::query()
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->roleFilter, function($q) {
                $q->where('role', $this->roleFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.users.index', [
            'users' => $users
        ]);
    }
}