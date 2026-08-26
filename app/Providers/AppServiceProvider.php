<?php

namespace App\Providers;

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
        \Illuminate\Pagination\Paginator::useBootstrapFour();

        view()->composer('*', function ($view) {
            $view->with('profile', \App\Models\VillageProfile::first() ?? new \App\Models\VillageProfile());
        });

        view()->composer('layouts.app', function ($view) {
            // Log visitor on public pages
            if (!request()->is('admin*') && !request()->is('api*')) {
                try {
                    \App\Models\VisitorLog::firstOrCreate([
                        'ip_address' => request()->ip(),
                        'visit_date' => today()->toDateString(),
                    ]);
                } catch (\Exception $e) {
                    // Ignore unique constraint concurrency exceptions silently
                }
            }

            // Fetch statistics
            try {
                $todayDate = today()->toDateString();
                $startOfMonth = today()->startOfMonth()->toDateString();

                $visitorStats = [
                    'today' => \App\Models\VisitorLog::where('visit_date', $todayDate)->count(),
                    'month' => \App\Models\VisitorLog::where('visit_date', '>=', $startOfMonth)->count(),
                    'total' => \App\Models\VisitorLog::count(),
                ];
            } catch (\Exception $e) {
                $visitorStats = [
                    'today' => 0,
                    'month' => 0,
                    'total' => 0,
                ];
            }

            $view->with('visitorStats', $visitorStats);
        });
    }
}
