<?php

namespace App\Console;

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
        
        Commands\AutoCloseTicket::class,
        Commands\AutoOverdueTicket::class,
        Commands\AutoResponseTicket::class,
        Commands\AutoNotificationdeletes::class,
        Commands\EmailtoTicket::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('ticket:autoclose')->everyMinute();
        $schedule->command('ticket:autooverdue')->everyMinute();
        $schedule->command('ticket:autoresponseticket')->everyMinute();
        $schedule->command('notification:autodelete')->everyMinute();
        $schedule->command('imap:emailticket')->everyMinute();
        


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
