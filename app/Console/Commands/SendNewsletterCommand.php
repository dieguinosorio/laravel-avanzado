<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Notifications\NewsLetterNotification;
class SendNewsletterCommand extends Command
{
    
    protected $signature = 'send:newsletter {emails?*} : Correos electronicos a los cuales enviar directamente {--s|schedule : Si debe ser ejecutado automaticamente o no }';

    protected $description = 'Envia un correo electronico';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $emails = $this->arguments('emails');
        $builder = User::query();
        $schedule = $this->option('schedule');
        if($emails) {
            //$builder->whereIn('email',$emails);
        }

        $count = $builder->count();
        if($count){
            if($this->confirm("Estas de acuerdo ? ") || $schedule){
                $this->output->progressStart();
                $builder->whereNotNull('email_verified_at')->each(function(User $user){
                    $user->notify(new NewsLetterNotification("Hola {$user->name} por usar nuestros servicios con el email {$user->email}"));
                    $this->output->progressAdvance();
                });
                $this->info("Se enviaron {$count} emails");
                $this->output->progressFinish();
            }
            else{
                $this->info('No se envio ningun correo');
            }
        }
        else{
            $this->info('No se envio ningun correo');
        }
        
    }
}
