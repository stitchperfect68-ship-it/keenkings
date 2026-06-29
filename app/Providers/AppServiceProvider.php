<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Run any pending migrations automatically in production.
        // Handles Railway deployments where releaseCommand may not fire.
        if (config('app.env') === 'production' && !app()->runningInConsole()) {
            $this->runPendingMigrations();
        }
    }

    private function runPendingMigrations(): void
    {
        // Cache the check for 10 minutes to avoid running on every request
        $cacheKey = 'migrations_checked_' . md5(base_path('database/migrations'));
        if (Cache::get($cacheKey)) {
            return;
        }

        try {
            $pending = DB::table('migrations')
                ->get()
                ->pluck('migration')
                ->toArray();

            $files = collect(scandir(base_path('database/migrations')))
                ->filter(fn($f) => str_ends_with($f, '.php'))
                ->map(fn($f) => pathinfo($f, PATHINFO_FILENAME))
                ->values();

            $hasPending = $files->contains(
                fn($f) => !in_array($f, $pending)
            );

            if ($hasPending) {
                Artisan::call('migrate', ['--force' => true]);
            }

            Cache::put($cacheKey, true, now()->addMinutes(10));
        } catch (\Exception) {
            // Migrations table itself might not exist yet — run migrate to create it
            try {
                Artisan::call('migrate', ['--force' => true]);
                Cache::put($cacheKey, true, now()->addMinutes(10));
            } catch (\Exception) {
                // Silently fail — site stays up, admin will see error on next save
            }
        }
    }
}
