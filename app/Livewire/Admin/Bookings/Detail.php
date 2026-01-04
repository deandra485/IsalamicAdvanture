<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[layout('layouts.admin')]
class Detail extends Component
{
    public Booking $booking;
    public $showStatusModal = false;
    public $newStatus;
    public $adminNotes = '';

    public function mount(Booking $booking)
    {
        $this->booking = $booking->load([
            'user',
            'items.equipment.category',
            'payment.verifiedBy',
            'confirmedBy',
            'package'
        ]);
        $this->adminNotes = $booking->catatan_admin ?? '';
    }

    public function openStatusModal($status)
    {
        $this->newStatus = $status;
        $this->showStatusModal = true;
    }

    public function updateStatus()
    {
        try {
            $oldStatus = $this->booking->status_booking;
            
            $this->booking->update([
                'status_booking' => $this->newStatus,
                'confirmed_by' => Auth::id(),
            ]);

            // Log activity
            \App\Models\ActivityLog::log(
                'update',
                'bookings',
                $this->booking->id,
                "Changed status from {$oldStatus} to {$this->newStatus}"
            );

            // Send notification
            if ($this->newStatus === 'confirmed') {
                $this->booking->user->notify(new \App\Notifications\BookingConfirmed($this->booking));
            }

            $this->showStatusModal = false;
            $this->booking->refresh();
            session()->flash('success', 'Status booking berhasil diubah!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function saveNotes()
    {
        $this->booking->update([
            'catatan_admin' => $this->adminNotes,
        ]);

        \App\Models\ActivityLog::log(
            'update',
            'bookings',
            $this->booking->id,
            'Updated admin notes'
        );

        session()->flash('success', 'Catatan berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.bookings.detail');
    }
}
