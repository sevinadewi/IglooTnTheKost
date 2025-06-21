<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    function login() {
        return view('login');
    }
    
    function authenticating(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended(route('property.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    function logout(Request $request) {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('login');
    }

    function register(){

        if (Auth::check()) {
            // Jika sudah login dan belum verifikasi, arahkan ke halaman verifikasi
            if (is_null(Auth::user()->email_verified_at)) {
                return redirect('/email/verify');
            }

            // Jika sudah login dan sudah verifikasi, arahkan ke halaman
            return redirect('login');
        }
        return view('register');
    }

    function createUser(Request $request){
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Auth::login($user);

        event(new Registered($user));
        // return redirect('/login');
        return redirect()->route('verification.notice');
    }

}
