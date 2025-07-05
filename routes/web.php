<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\AdminController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengingatTagihanMail;


Route::get('/profile', function () {
    return auth()->user()->name;
})->middleware('verified');


Route::middleware(['auth', 'verified'])->group(function (){
    
});

// Route::get('/dashboard-index', function () {
//     return view('dashboard.dashboard-index');
//     });

// Route::get('/dashboard-tagihan', function () {
//     return view('dashboard.dashboard-tagihan');
//     });

Route::middleware(['auth'])->group(function (){
    // Route::get('/', function () {
    // return view('welcome');
    // });

    


//  Route::get('/logout', function () {
//     return view('contohlogout');
//     });
   

    Route::get('/property', [PropertyController::class, 'index'])->name('property.index');

    Route::post('/property', [PropertyController::class, 'store'])->name('property.store');
    Route::post('/property/room', [PropertyController::class, 'storeRoom'])->name('property.storeRoom');
    Route::post('/property/tenant/store', [PropertyController::class, 'storeTenant'])->name('property.storeTenant');

    Route::get('/property/reset', [PropertyController::class, 'resetStep'])->name('property.reset');
    Route::post('/property', [PropertyController::class, 'store'])->name('property.store');
    Route::get('/property/display-property', [PropertyController::class, 'showProperty'])->name('property.display-property');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::post('/penghuni', [TenantController::class, 'store'])->name('tenants.store');
    Route::put('/penghuni/{tenant}', [RoomController::class, 'update'])->name('tenants.update');
    Route::get('/penghuni/{id}/histori-penghuni', [TenantController::class, 'history'])->name('histori-penghuni');


    // Route::post('/tenant/store', [TenantController::class, 'store'])->name('tenant.store');


    // dashboard
    Route::get('/dashboard-index/{id}', [DashboardController::class, 'show'])->name('property.dashboard');
    Route::get('/dashboard-kamar/{id}', [RoomController::class, 'dashboardViewByProperty'])->name('dashboard-kamar');
    Route::get('/dashboard-penghuni/{id}', [TenantController::class, 'index'])->name('dashboard-penghuni');
    // Route::get('/dashboard-kamar/{id}', [DashboardController::class, 'showRooms'])->name('dashboard.kamar');
    // web.php
    Route::patch('/tenants/{tenant}/keluar', [TenantController::class, 'keluar'])->name('tenants.keluar');
    // Pengaturan Properti
    Route::get('/property/{id}/setting', [PropertyController::class, 'setting'])->name('property.setting');

    // Edit dan Update
    Route::get('/property/{id}/edit', [PropertyController::class, 'edit'])->name('property.edit');
    Route::put('/property/{id}', [PropertyController::class, 'update'])->name('property.update');

    // Delete
    Route::delete('/property/{id}', [PropertyController::class, 'destroy'])->name('property.destroy');



    Route::resource('rooms', RoomController::class)->except(['edit', 'create', 'show']);
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');


    Route::prefix('tenants')->name('tenants.')->group(function () {
        // Route::get('/', [TenantController::class, 'index'])->name('index');
        // Route::get('/create', [TenantController::class, 'create'])->name('create');
        // Route::post('/', [TenantController::class, 'store'])->name('store');
        // Route::get('/{tenant}/edit', [TenantController::class, 'edit'])->name('edit');
        Route::put('/{tenant}', [TenantController::class, 'update'])->name('update');
        Route::delete('/{tenant}', [TenantController::class, 'destroy'])->name('destroy');
        
    });

    Route::prefix('reservations')->group(function () {
        Route::get('/{propertyId}', [ReservationController::class, 'index'])->name('dashboard-pemesanan');
        Route::get('/create/{propertyId}', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/store', [ReservationController::class, 'store'])->name('reservations.store');
        Route::post('/accept/{reservation}', [ReservationController::class, 'accept'])->name('reservations.accept');
        Route::delete('/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });

    // Route::get('/dashboard-penghuni', [TenantController::class, 'index'])->name('dashboard-penghuni');
    // web.php
    

    // Route::get('/dashboard-penghuni/{propertyId}', [TenantController::class, 'showTenant'])->name('dashboard.dashboard-penghuni');
    Route::get('/dashboard-tagihan/{propertyId}', [BillController::class, 'index'])->name('dashboard-tagihan');
    Route::patch('/bills/{bill}/status', [BillController::class, 'updateStatus'])->name('bills.updateStatus');


        
});

// Auth pages
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'login']); 
Route::post('/login', [AuthController::class, 'authenticating']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'createUser']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/assign-property', [AdminController::class, 'assignProperty'])->name('admin.assignProperty');
    Route::post('/admin/update-role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
    Route::get('/admin/user/{id}/properties', [AdminController::class, 'editUserProperties'])->name('admin.editUserProperties');
    Route::post('/admin/user/{id}/properties', [AdminController::class, 'updateUserProperties'])->name('admin.updateUserProperties');
    Route::get('/admin/user-role', [AdminController::class, 'editUserRole'])->name('admin.edit-user-role');


});

Route::get('/test-email/{tenantId}', function ($tenantId) {
    $tenant = Tenant::findOrFail($tenantId);

    if (!$tenant->email) {
        return "Tenant ini belum memiliki email.";
    }

    Mail::to($tenant->email)->send(new PengingatTagihanMail($tenant));

    return "Email pengingat berhasil dikirim ke " . $tenant->email;
});

// use App\Models\Property;

// Route::get('/repair-property-user', function () {
//     $properties = Property::all();

//     foreach ($properties as $property) {
//         if ($property->user_id && !$property->users->contains($property->user_id)) {
//             $property->users()->attach($property->user_id);
//         }
//     }

//     return 'Selesai memperbaiki relasi user-properti!';
// });

