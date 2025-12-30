<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AdminViewServiceProvider extends ServiceProvider
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
    public function boot()
    {
        // Share admin data with all views inside admin/layouts/
        View::composer('admin.layout.*', function ($view) {
            $adminData = Auth::guard('admin')->user();
            $view->with('adminData', $adminData);
        });
    }
}
