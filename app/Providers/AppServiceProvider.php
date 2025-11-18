<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;

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
        // Kirim jumlah item keranjang ke semua view
        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Total qty di keranjang user
                $cartCount = Keranjang::where('user_id', Auth::id())->sum('qty');
            } else {
                $cartCount = 0;
            }

            // kirim ke semua view
            $view->with('cartCount', $cartCount);
        });
    }
}
