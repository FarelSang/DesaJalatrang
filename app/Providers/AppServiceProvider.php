<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Nama hari & bulan dalam bahasa Indonesia (Sen, Sep, Okt, ...)
        app()->setLocale('id');
        Carbon::setLocale('id');
    }
}
