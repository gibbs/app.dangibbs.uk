<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @inheritDoc
     */
    protected function schedule(Schedule $schedule): void
    {
        // Linux EOL
        $schedule->command('cache:eol-linux')->weekly();

        // GitHub activity feed (commits)
        $schedule->command('cache:activityfeed')->hourly();

        // GitHub insights (languages)
        $schedule->command('cache:insights')->weekly();
    }

    /**
     * @inheritDoc
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
