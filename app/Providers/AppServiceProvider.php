<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Property;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layout.master', function ($view) {
        // $view->with('property', Property::select('id', 'nama')->first());
            // Coba ambil dari parameter route 'id' atau 'property_id'
            $routeId = request()->route('id') ?? request()->route('propertyId') ?? request()->route('property_id');

            if ($routeId) {
                $property = Property::select('id', 'nama')->find($routeId);
                $view->with('property', $property);
            } else {
                // Jika tidak ada parameter di route, bisa skip atau kasih default
                $view->with('property', null); // atau Property::first() jika ingin fallback
            }
        });

        View::composer('layout.admin-master', function ($view) {
            $authUser = Auth::user();
            
            if ($authUser instanceof \App\Models\User) {
                // Pastikan load hanya dipanggil kalau user tidak null
                $user = $authUser->load('properties');
                $view->with('user', $user);
            } else {
                $view->with('user', null);
            }
        });
    }
}
