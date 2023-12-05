<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            // Aturan validasi: hanya huruf dan spasi diizinkan
            return preg_match('/^[\pL\s]+$/u', $value);
        });
    
        Validator::replacer('alpha_spaces', function ($message, $attribute, $rule, $parameters) {
            // Pesan kesalahan khusus untuk aturan alpha_spaces
            return str_replace(':attribute', $attribute, 'Bagian ini hanya boleh berisi huruf dan spasi');
        });
    }
}