<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TenantController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengingatTagihanMail;



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



// Route::get('/register', function(){
//     return view('register');
// });
// Route::get('/login', function () {
//     return view('login');
// });
Route::get('/profile', function () {
    return auth()->user()->name;
})->middleware('verified');


Route::middleware(['auth', 'verified'])->group(function (){
    
});

// Route::get('/dashboard-index', function () {
//     return view('dashboard.dashboard-index');
//     });

Route::get('/dashboard-tagihan', function () {
    return view('dashboard.dashboard-tagihan');
    });

Route::middleware(['auth'])->group(function (){
    // Route::get('/', function () {
    // return view('welcome');
    // });

    Route::get('/contohlogout', function () {
    return view('contohlogout');
    });

    // Route::get('/property', function () {
    // return view('property');
    // });

    // Route::get('/property', [PropertyController::class, 'index'])->name('property.index');
    // Route::post('/property', [PropertyController::class, 'store'])->name('property.store');
    // Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    // Route::get('/tenant', [TenantController::class, 'index'])->name('tenant.index');
    // Route::get('/tenant/create', [TenantController::class, 'create'])->name('tenant.create');
    // Route::post('/tenant/store', [TenantController::class, 'store'])->name('tenant.store');
    // Route::get('/tenant/{tenant}/edit', [TenantController::class, 'edit'])->name('tenant.edit');
    // Route::put('/tenant/{tenant}/update', [TenantController::class, 'update'])->name('tenant.update');
    // Route::delete('/tenant/{tenant}/destroy', [TenantController::class, 'destroy'])->name('tenant.destroy');
    Route::get('/property', [PropertyController::class, 'index'])->name('property.index');

    Route::post('/property', [PropertyController::class, 'store'])->name('property.store');
    Route::post('/property/room', [PropertyController::class, 'storeRoom'])->name('property.storeRoom');
    Route::post('/property/tenant/store', [PropertyController::class, 'storeTenant'])->name('property.storeTenant');

    Route::get('/property/reset', [PropertyController::class, 'resetStep'])->name('property.reset');
    Route::post('/property', [PropertyController::class, 'store'])->name('property.store');
    Route::get('/property/display-property', [PropertyController::class, 'showProperty'])->name('property.display-property');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');

    // Route::post('/tenant/store', [TenantController::class, 'store'])->name('tenant.store');


    // dashboard
    Route::get('/dashboard-index/{id}', [DashboardController::class, 'show'])->name('property.dashboard');
    Route::get('/dashboard-kamar/{id}', [RoomController::class, 'dashboardViewByProperty'])->name('dashboard-kamar');
    Route::get('/dashboard-penghuni/{id}', [TenantController::class, 'index'])->name('dashboard-penghuni');
    // Route::get('/dashboard-kamar/{id}', [DashboardController::class, 'showRooms'])->name('dashboard.kamar');
    // web.php
    Route::patch('/tenants/{tenant}/keluar', [TenantController::class, 'keluar'])->name('tenants.keluar');


    Route::resource('rooms', RoomController::class);

    Route::prefix('tenants')->name('tenants.')->group(function () {
        // Route::get('/', [TenantController::class, 'index'])->name('index');
        // Route::get('/create', [TenantController::class, 'create'])->name('create');
        Route::post('/', [TenantController::class, 'store'])->name('store');
        Route::get('/{tenant}/edit', [TenantController::class, 'edit'])->name('edit');
        Route::put('/{tenant}', [TenantController::class, 'update'])->name('update');
        Route::delete('/{tenant}', [TenantController::class, 'destroy'])->name('destroy');
        
    });
    // Route::get('/dashboard-penghuni', [TenantController::class, 'index'])->name('dashboard-penghuni');
    // web.php
    

    // Route::get('/dashboard-penghuni/{propertyId}', [TenantController::class, 'showTenant'])->name('dashboard.dashboard-penghuni');


});

// Auth pages
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticating']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'createUser']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification
Route::middleware('auth')->group(function (){
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
        // return redirect('/profile');
        return redirect()->route('login')->with('status', 'Email berhasil diverifikasi');
    })->middleware(['auth', 'signed'])->name('verification.verify');

});

// Reset Password
Route::middleware('guest')->group(function (){
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});


Route::get('/test-email/{tenantId}', function ($tenantId) {
    $tenant = Tenant::findOrFail($tenantId);

    if (!$tenant->email) {
        return "Tenant ini belum memiliki email.";
    }

    Mail::to($tenant->email)->send(new PengingatTagihanMail($tenant));

    return "Email pengingat berhasil dikirim ke " . $tenant->email;
});