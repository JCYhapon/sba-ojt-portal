<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Company;
use App\Models\PasswordReset;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $companies = Company::all();

            foreach ($companies as $company) {
                $createdAt = $company->created_at;
                $diffInYears = $createdAt->diffInYears(now());

                if ($diffInYears >= 2) {
                    $company->status = 2;
                    $company->save();
                }
            }
        })->dailyAt('03:00');
        $schedule->call(function () {
            PasswordReset::truncate();
        })->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
