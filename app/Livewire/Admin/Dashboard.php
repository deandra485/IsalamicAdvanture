<?php
// ==========================================
// APP/LIVEWIRE/ADMIN/DASHBOARD.PHP
// ==========================================

namespace App\Livewire\Admin;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use App\Models\Equipment;
use App\Models\User;
use App\Models\Payment;
use Livewire\Component;
use Carbon\Carbon;

#[layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status_booking', 'pending')->count(),
            'total_equipment' => Equipment::count(),
            'available_equipment' => Equipment::where('is_available', true)->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'pending_payments' => Payment::where('status_pembayaran', 'pending')->count(),
            'monthly_revenue' => Payment::where('status_pembayaran', 'verified')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('jumlah_bayar'),
            'today_bookings' => Booking::whereDate('created_at', today())->count(),
        ];

        $recentBookings = Booking::with(['user', 'items.equipment'])
            ->latest()
            ->take(5)
            ->get();

        $pendingPayments = Payment::with('booking.user')
            ->where('status_pembayaran', 'pending')
            ->whereNotNull('bukti_pembayaran_url')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentBookings' => $recentBookings,
            'pendingPayments' => $pendingPayments,
        ]);
    }
}