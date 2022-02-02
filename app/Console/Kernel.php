<?php

namespace App\Console;

use App\Console\Commands\SendNewsletterCommand;
use App\Console\Commands\SendUserNotVerifiedMailCommand;
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
        SendNewsletterCommand::class,
        SendUserNotVerifiedMailCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //evenInMaintenanceMode Sirve para ejecutar la tarea asi este en modo mantenimiento
        //sendOutputTo indica la carpeta donde se va guardar el log
        $schedule->command('inspire')->evenInMaintenanceMode()->sendOutputTo(storage_path('inspire.log'))->everyMinute();
        $schedule->call(function(){
            echo "Hola";
        })->everyFiveMinutes();
        //onOneServer se ejecuta en un solo servidor para que no lleguen varios correos
        //withoutOverlapping evita que no se ejecute si ya hay una instancia del comando corriendo
        $schedule->command(SendNewsletterCommand::class)->withoutOverlapping()->onOneServer()->mondays();
        $schedule->command(SendUserNotVerifiedMailCommand::class)->onOneServer()->daily();
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
