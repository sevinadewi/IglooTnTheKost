<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Property;

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
            $routeId = request()->route('id') ?? request()->route('property_id');

            if ($routeId) {
                $property = Property::select('id', 'nama')->find($routeId);
                $view->with('property', $property);
            } else {
                // Jika tidak ada parameter di route, bisa skip atau kasih default
                $view->with('property', null); // atau Property::first() jika ingin fallback
            }
        });
    }
}
