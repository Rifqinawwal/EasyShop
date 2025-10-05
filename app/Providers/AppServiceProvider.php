<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <-- Tambahkan ini
use App\Models\Category;             // <-- Tambahkan ini

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
        // Bagikan variabel 'categories' ke semua view
        View::composer('*', function ($view) {
            $view->with('categories', Category::all());
        });
    }
}