<?php

namespace App\Http\Controllers;

use App\Console\Commands\SendUserNotVerifiedMailCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class NewsLetterController extends Controller
{
    public function send(){
        //Ejecutamos el comando ya creado
        Artisan::call(SendUserNotVerifiedMailCommand::class);
        return [
            'data'=>'Todo ok'
        ];
    }
}
