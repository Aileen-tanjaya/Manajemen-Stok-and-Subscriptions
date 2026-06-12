<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StokController;

// Import controller baru dari gambar
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminSubscriptionReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// TAMBAHAN: Import Model User & Hash agar fitur pembuat user otomatis bisa berjalan
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// DIUBAH: Logika pengalihan otomatis saat login masuk ke dashboard
Route::get('/dashboard', function () {
    // Jika yang login rolenya admin, tampilkan halaman dashboard biasa
    if (auth()->user()->role === 'admin') {
        return view('dashboard');
    }
    
    // Tapi jika user biasa, langsung lempar ke halaman pilih paket!
    return redirect()->route('subscriptions.plans');
})->middleware(['auth', 'verified'])->name('dashboard');

// TAMBAHAN: Rute rahasia untuk mendaftarkan user@mail.com lewat browser (100% AMAN)
Route::get('/buat-user', function () {
    User::updateOrCreate(
        ['email' => 'user@mail.com'],
        [
            'name' => 'User Biasa',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]
    );
    return 'Akun user@mail.com berhasil didaftarkan secara aman! Silakan coba login.';
});

// KODE DIRAPIKAN: Hak akses yang bisa dibuka oleh semua user yang sudah login (Admin & User Biasa)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // (Rute manajemen users, products, dan stok dipindahkan ke bawah agar tidak tabrakan)

    Route::get('/plans', [SubscriptionController::class, 'plans'])->name('subscriptions.plans');
    Route::post('/plans/{plan}/checkout', [SubscriptionController::class, 'checkout'])->name('subscriptions.checkout');
    
    Route::get('/subscriptions/{subscription}/payment', [SubscriptionController::class, 'payment'])->name('subscriptions.payment');
    Route::post('/subscriptions/{subscription}/pay', [SubscriptionController::class, 'pay'])->name('subscriptions.pay');
    Route::get('/my-subscriptions', [SubscriptionController::class, 'my'])->name('subscriptions.my');
});

// KODE DIRAPIKAN: Kelompok rute khusus Admin (User biasa tidak akan error membaca rute ini)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    Route::resource('stok', StokController::class);
    Route::get('/admin/subscription-report', [AdminSubscriptionReportController::class, 'index'])->name('admin.subscription-report');
});

Route::get('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->middleware('auth')->name('logout');

require __DIR__.'/auth.php';