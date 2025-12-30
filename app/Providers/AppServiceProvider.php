<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\rise\Categories;
use App\Models\rise\PageSetting;
use App\Models\rise\TypesOf;
use Illuminate\Support\Facades\View;
use App\Models\rise\Headings;

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
        // Header composer
        View::composer('layouts.header', function ($view) {
            $mainCategories = Categories::whereNull('category_id')
                ->where('status', 1)
                ->with(['children' => function ($query) {
                    $query->where('status', 1);
                }])
                ->get()
                ->groupBy('type_id');
    
            $pageData = PageSetting::first();
            $types = TypesOf::orderBy('order_no', 'asc')->get();
    
            $view->with([
                'mainCategories' => $mainCategories,
                'pageData' => $pageData,
                'types' => $types,
            ]);
        });
    
        // Footer composer
        View::composer('layouts.footer', function ($view) {
            $pageData = PageSetting::first();
            $view->with([
                'pageData' => $pageData
            ]);
        });
    
        // Global headings for all views
        view()->composer('*', function ($view) {
            $headings = Headings::where('status', 1)
                                ->orderBy('order_no', 'asc')
                                ->get();
            $view->with('allHeadings', $headings);
        });
    }

}
