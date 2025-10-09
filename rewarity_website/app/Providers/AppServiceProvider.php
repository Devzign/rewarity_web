<?php

namespace App\Providers;

use App\Support\DefaultAdmin;
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
        $shouldEnsureDefaultAdmin = filter_var(
            config('admin.ensure_default_on_boot', true),
            FILTER_VALIDATE_BOOLEAN
        );

        if ($shouldEnsureDefaultAdmin) {
            DefaultAdmin::ensure();
        }
    }
}
