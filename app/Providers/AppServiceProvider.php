<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Schema;
use App\Listeners\MergeCartOnLogin;
use App\Models\Categorie;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Fix MySQL "key too long" error (utf8mb4)
        Schema::defaultStringLength(191);

        // Injecter $categories dans toutes les vues du layout client
        View::composer('*', function ($view) {
            if (!isset($view->getData()['categories'])) {
                $view->with('categories', Categorie::all());
            }
        });

        // Fusionner le panier de session avec le compte au moment de la connexion
        Event::listen(Login::class, MergeCartOnLogin::class);
    }
}
