<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Laravel\Socialite\Facades\Socialite; 
use App\Models\User; 
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/*
|--------------------------------------------------------------------------
| AUTH LIVEWIRE
|--------------------------------------------------------------------------
*/
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ForgotPassword;

/*
|--------------------------------------------------------------------------
| PUBLIC LIVEWIRE
|--------------------------------------------------------------------------
*/
use App\Livewire\Home;
use App\Livewire\Gallery;
use App\Livewire\Mountains\Index as MountainsIndex;
use App\Livewire\Mountains\Show as MountainShow;
use App\Livewire\Equipment\Index as EquipmentIndex;
use App\Livewire\Equipment\Show as EquipmentShow;
use App\Livewire\Packages\Index as PackagesIndex;
use App\Livewire\Packages\Show as PackageShow;

/*
|--------------------------------------------------------------------------
| USER LIVEWIRE
|--------------------------------------------------------------------------
*/
use App\Livewire\Booking\Cart;
use App\Livewire\Booking\Checkout;
use App\Livewire\Payment\Process as PaymentProcess;
use App\Livewire\User\Dashboard;
use App\Livewire\User\BookingHistory;
use App\Livewire\User\Profile;
use App\Livewire\User\BookingShow;

/*
|--------------------------------------------------------------------------
| ADMIN LIVEWIRE
|--------------------------------------------------------------------------
*/
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Mountains\Index as AdminMountainsIndex;
use App\Livewire\Admin\Mountains\Form as AdminMountainForm;
use App\Livewire\Admin\Equipment\Index as AdminEquipmentIndex;
use App\Livewire\Admin\Equipment\Form as AdminEquipmentForm;
use App\Livewire\Admin\Categories\Index as AdminCategoriesIndex;
use App\Livewire\Admin\Packages\Index as AdminPackagesIndex;
use App\Livewire\Admin\Packages\Form as AdminPackageForm;
use App\Livewire\Admin\Bookings\Index as AdminBookingsIndex;
use App\Livewire\Admin\Bookings\Detail as AdminBookingDetail;
use App\Livewire\Admin\Payments\Index as AdminPaymentsIndex;
use App\Livewire\Admin\Payments\Show as PaymentShow;
use App\Livewire\Admin\Reviews\Index as AdminReviewsIndex;
use App\Livewire\Admin\Users\Index as AdminUsersIndex;
use App\Livewire\Admin\Reports\Index as AdminReportsIndex;
use Illuminate\Http\Request;
use App\Models\Booking;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', Home::class)->name('home');
Route::get('/gallery', Gallery::class)->name('gallery');

/*
|--------------------------------------------------------------------------
| AUTH (GUEST & SOCIALITE)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');

    // --- GOOGLE LOGIN ROUTES ---
    Route::get('/auth/google', function () {
        return Socialite::driver('google')->redirect();
    })->name('auth.google');

    Route::get('/auth/google/callback', function () {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)), 
                'email_verified_at' => now(), 
                // 'is_active' => true, // Uncomment jika perlu
            ]);
        
            Auth::login($user, true);
        
            if ($user->role === 'admin') { 
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    });
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');


Route::get('/sitemap.xml', function () {
    return Sitemap::create()
        ->add('/')
        ->add('/paket')
        ->toResponse(request());
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('mountains')->name('mountains.')->group(function () {
    Route::get('/', MountainsIndex::class)->name('index');
    Route::get('{mountain}', MountainShow::class)->name('show');
});

Route::prefix('equipment')->name('equipment.')->group(function () {
    Route::get('/', EquipmentIndex::class)->name('index');
    Route::get('{equipment}', EquipmentShow::class)->name('show');
});

Route::prefix('packages')->name('packages.')->group(function () {
    Route::get('/', PackagesIndex::class)->name('index');
    Route::get('{package}', PackageShow::class)->name('show');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER (DIPISAH JADI 2 GROUP)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active'])->group(function () {

    // 1. Group User Dashboard & Profile (Prefix: user.xxx)
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/bookings', BookingHistory::class)->name('bookings.history');
        Route::get('/bookings/{booking}', BookingShow::class)->name('bookings.show');
        Route::get('/profile', Profile::class)->name('profile');
        
        // Tetap di user.payment.process (sesuai logika user dashboard)
        Route::get('/payment/{booking}', PaymentProcess::class)->name('payment.process');
    });

    // 2. Group Booking Process / Cart (Prefix: booking.xxx)
    // INI YANG MEMPERBAIKI ERROR 'booking.cart'
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/cart', Cart::class)->name('cart');
        Route::get('/checkout', Checkout::class)->name('checkout');
    });

});

/*
|--------------------------------------------------------------------------
| ADMIN (PREFIX admin.)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin', 'active'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', AdminDashboard::class)->name('dashboard');

        Route::prefix('mountains')->name('mountains.')->group(function () {
            Route::get('/', AdminMountainsIndex::class)->name('index');
            Route::get('create', AdminMountainForm::class)->name('create');
            Route::get('{mountain}/edit', AdminMountainForm::class)->name('edit');
        });

        Route::prefix('equipment')->name('equipment.')->group(function () {
            Route::get('/', AdminEquipmentIndex::class)->name('index');
            Route::get('create', AdminEquipmentForm::class)->name('create');
            Route::get('{equipment}/edit', AdminEquipmentForm::class)->name('edit');
        });

        Route::get('categories', AdminCategoriesIndex::class)->name('categories.index');

        Route::prefix('packages')->name('packages.')->group(function () {
            Route::get('/', AdminPackagesIndex::class)->name('index');
            Route::get('create', AdminPackageForm::class)->name('create');
            Route::get('{package}/edit', AdminPackageForm::class)->name('edit');
        });

        Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', AdminBookingsIndex::class)->name('index');

        // --- BAGIAN BARU: Route Cetak Laporan (Tanpa Controller) ---
        Route::get('/print-daily', function (Request $request) {
            // 1. Ambil tanggal dari URL, jika tidak ada pakai hari ini
            $date = $request->query('date', now()->format('Y-m-d'));

            // 2. Ambil data booking sesuai tanggal tersebut
            // Anda bisa ganti 'created_at' dengan 'tanggal_mulai' jika ingin laporan berdasarkan jadwal naik
            $bookings = Booking::with(['user', 'items', 'payment'])
                        ->whereDate('created_at', $date) 
                        ->latest()
                        ->get();

            // 3. Hitung ringkasan
            $totalRevenue = $bookings->where('status_booking', '!=', 'cancelled')->sum('total_biaya');
            $totalTransactions = $bookings->count();

            // 4. Return ke Blade khusus cetak
            return view('pdf.booking', compact('bookings', 'date', 'totalRevenue', 'totalTransactions'));
        })->name('pdf');
        Route::get('{booking}', AdminBookingDetail::class)->name('detail');
        });

        Route::get('payments', AdminPaymentsIndex::class)->name('payments.index');
        Route::get('/payments/{payment}', PaymentShow::class)->name('payments.show');
        Route::get('reviews', AdminReviewsIndex::class)->name('reviews.index');
        Route::get('users', AdminUsersIndex::class)->name('users.index');
        Route::get('reports', AdminReportsIndex::class)->name('reports.index');
});