<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Validation\ValidationException;
use App\User;

class UserTokenController extends Controller
{
    
    public function __invoke(Request $request)
    {
        $request->validate([
            'email'=>'required | email',
            'password'=>'required',
            'device_name' => 'required'
        ]);
        
        $user = User::where('email', $request->email)->first();
        if (!$user || ($user && !Hash::check($request->password, $user->password))) {
            if(!Hash::check($request->password, $user->password)){
               //throw  ValidationException::withMessages(['password'=> 'La contrasena es incorrecta.']);
               
                return ['password'=> 'La contrasena es incorrecta.'];
               
            }
            else{
                //throw  ValidationException::withMessages(['email' => 'El usuario no se encuentra o es incorrecto ']);
                return ['email' => 'El usuario no se encuentra o es incorrecto '];
            }
        }
        
        return [
            'token' => $user->createToken($request->device_name)->plainTextToken
        ];
    }
}
