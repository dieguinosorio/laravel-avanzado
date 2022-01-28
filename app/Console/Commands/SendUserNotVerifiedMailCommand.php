<?php

namespace App\Console\Commands;

use App\Notifications\UsersVerifiedMailNotification;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendUserNotVerifiedMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:verifiedmail{emails?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificacion de email por parte de usuarios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = $this->arguments('emails');
        $builder = User::query();
        if($builder->count()){
            $this->output->progressStart();
            $builder->whereNull('email_verified_at')->whereRaw('created_at = ?', DB::raw('DATE_ADD(NOW(), INTERVAL 1 WEEK'))
            ->each(function(User $user){
                $user->notify(new UsersVerifiedMailNotification('Recuerda que debes verificar tu cuenta da click al enlace'));
                $this->output->progressAdvance();
            });
            $this->info("Se enviaron {$builder->count()} emails");
            $this->output->progressFinish();
        }
        else{
            $this->info("No se enviaron  emails");
        }
    }
}
