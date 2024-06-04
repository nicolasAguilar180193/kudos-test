<?php

namespace App\Providers;

use App\Repositories\ProductsConsult\IProductsConsultRepository;
use App\Repositories\ProductsConsult\ProductsConsultEloquentRepository;
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
        $this->app->bind(IProductsConsultRepository::class, ProductsConsultEloquentRepository::class);
    }
}
