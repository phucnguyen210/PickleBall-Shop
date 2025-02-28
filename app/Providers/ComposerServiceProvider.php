<?php

namespace App\Providers;

use App\Models\Category;
use App\View\Composers\CategoryComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer([
            'admin.categories.list',
            'front-end.layouts.header',
            'admin.categories.edit',
        ], CategoryComposer::class);
    }
}