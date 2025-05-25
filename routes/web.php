<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;



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

Route::middleware(['auth'])->group(function (){
    Route::get('/', function () {
    return view('welcome');
    });

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
Route::post('/property/tenant', [PropertyController::class, 'storeTenant'])->name('property.storeTenant');

Route::get('/property/reset', [PropertyController::class, 'resetStep'])->name('property.reset');
    Route::post('/property', [PropertyController::class, 'store'])->name('property.store');

Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');

Route::post('/tenant/store', [TenantController::class, 'store'])->name('tenant.store');

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
 
        return redirect('/profile');
    })->middleware(['auth', 'signed'])->name('verification.verify');

});

// Reset Password
Route::middleware('guest')->group(function (){
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});