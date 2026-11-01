<?php

namespace App\Providers;

use App\Models\IndexPartner;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
        Paginator::useBootstrapFive();

        View::composer('layouts.app', function ($view): void {
            $partners = Schema::hasTable('index_partners')
                ? IndexPartner::query()->latest()->get()
                : collect();

            $view->with('indexPartners', $partners);
        });
    }
}
