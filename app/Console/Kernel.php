<?php

namespace App\Console;

use App\Console\Commands\MonitorExecutor;
use App\Models\ScheduleRule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        MonitorExecutor::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        try {
            foreach (ScheduleRule::get() as $rule) {
                $schedule
                    ->command("watcher:execute {$rule->api_group_id}")
                    ->cron($rule->cron_expression)
                    ->when(function () use ($rule) {
                        return parse_schedule_condition($rule->cron_condition);
                    })
                    ->runInBackground();
            }
        } catch (\Exception $e) {}
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
