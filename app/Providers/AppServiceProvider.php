<?php

namespace App\Providers;
use App\Models\Liga; 
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // ===== TAMBAHKAN DARI SINI =====
        // Berbagi data liga ke semua view yang menggunakan layout 'public'
        View::composer('layouts.public', function ($view) {
            $ligas = Liga::with(['klubs' => function ($query) {
                $query->orderBy('nama');
            }])->orderBy('nama')->get();
            
            $view->with('ligasForMenu', $ligas);
        });
    }
}
