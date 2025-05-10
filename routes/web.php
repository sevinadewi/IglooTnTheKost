<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

});


    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticating']);
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'createUser']);


Route::middleware('auth')->group(function (){
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
        return redirect('/profile');
    })->middleware(['auth', 'signed'])->name('verification.verify');

});