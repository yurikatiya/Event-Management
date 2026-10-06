<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Sponsor;
use App\Models\Team;
use App\Observers\AdminContentObserver;
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
        foreach ([Event::class, Gallery::class, Category::class, Sponsor::class, Partner::class, Team::class] as $model) {
            $model::observe(AdminContentObserver::class);
        }
    }
}
