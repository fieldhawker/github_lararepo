<?php namespace App\Console;

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
      'App\Console\Commands\Inspire',
      'App\Console\Commands\CheckReportsCommand',
      'App\Console\Commands\GetSepInfoCommand',
      'App\Console\Commands\GetArmyInfoCommand',
      'App\Console\Commands\CheckAttendsCommand',
      'App\Console\Commands\ExportMonthlyAttendsCommand',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
          ->hourly();
        $schedule->command('batchCheckReports')->weekly()->tuesdays()->at('8:35');
        $schedule->command('batchGetSepInfo')->dailyAt('8:15');
        $schedule->command('batchGetArmyInfo')->dailyAt('14:25');
        $schedule->command('batchCheckAttends')->dailyAt('9:30');
        $schedule->command('batchExportMonthlyAttends')->monthly()->dailyAt('8:55');
    }

}
