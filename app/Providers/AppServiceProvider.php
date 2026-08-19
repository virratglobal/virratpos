<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Register custom UDF for FIND_IN_SET on SQLite connections to support MySQL compatibility locally
        try {
            if (\DB::connection() instanceof \Illuminate\Database\SQLiteConnection) {
                \DB::connection()->getPdo()->sqliteCreateFunction('FIND_IN_SET', function ($needle, $haystack) {
                    if ($needle === null || $haystack === null) {
                        return false;
                    }
                    return in_array((string)$needle, explode(',', (string)$haystack), true) ? 1 : 0;
                }, 2);
            }
        } catch (\Exception $e) {
            // Silence exceptions if DB is not ready/migrated yet
        }
    }
}
