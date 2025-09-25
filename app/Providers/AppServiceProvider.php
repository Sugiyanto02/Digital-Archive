<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Document;

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
        // memberi $totalDocuments ke semua view
        view::composer(['layouts.navigation', 'components.header', 'dashboard.*'], function($view) {
            $view->with('totalDocuments', Document::count());
        });
    }
}
