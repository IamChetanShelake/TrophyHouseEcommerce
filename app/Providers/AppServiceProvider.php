<?php

namespace App\Providers;

use App\Models\AwardCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
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
        Blade::directive('activeRoute', function ($prefix) {
            return "<?php echo request()->routeIs({$prefix}) ? 'active' : ''; ?>";
        });

        //  View::share('categories', AwardCategory::with('subcategories')->get());
    }
}