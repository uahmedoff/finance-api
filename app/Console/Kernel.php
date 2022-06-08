<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel{

    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule){
        // $schedule->command('inspire')->hourly();

        $schedule->command('daily:renew_currency_exchange_rate')->cron('0 6 * * *');
    }

    protected function commands(){
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
