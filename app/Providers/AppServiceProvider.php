<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{
    // Static flag: set once per PHP worker process so subsequent requests skip the check
    private static bool $migrationChecked = false;

    public function register(): void {}

    public function boot(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Auto-run pending migrations on Railway (releaseCommand not reliably firing)
        if (config('app.env') === 'production' && !app()->runningInConsole()) {
            $this->runPendingMigrations();
        }
    }

    private function runPendingMigrations(): void
    {
        if (static::$migrationChecked) {
            return;
        }
        static::$migrationChecked = true;

        try {
            $ran = DB::table('migrations')->pluck('migration')->toArray();

            $files = collect(glob(base_path('database/migrations/*.php')))
                ->map(fn($f) => pathinfo($f, PATHINFO_FILENAME));

            if ($files->contains(fn($f) => !in_array($f, $ran))) {
                Artisan::call('migrate', ['--force' => true]);
            }
        } catch (\Exception) {
            // migrations table itself doesn't exist — run migrate from scratch
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Exception) {
                // Silent fail — site stays up
            }
        }
    }
}
