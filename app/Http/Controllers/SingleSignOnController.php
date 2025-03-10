<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SingleSignOnController extends Controller
{



    public function singleSignOnRedirect($provider){ 
            return Socialite::driver($provider)->redirect();
        
    }


    public function singleSignOnCallback($provider){
            $user_provider = null;

            
            $user_provider = Socialite::driver($provider)->stateless()->user();
           

            //Busca el usuario por email
            $user = User::where('email', $user_provider->email)->first();

            
        
            if ($user) {
                // Si el usuario existe, actualiza el provider_id

                $user->update([
                    'provider_id' => $user_provider->id,
                    'name' => $user_provider->name,
                    'avatar' => $user_provider->avatar,
                    'email_verified_at' => now(), 
                ]);
            } else {
                // Si el usuario no existe, crea uno nuevo
                $user = User::create([
                    'provider_id' => $user_provider->id,
                    'name' => $user_provider->name,
                    'avatar' => $user_provider->avatar,
                    'email' => $user_provider->email,
                    'email_verified_at' => now(),
                ]);
            }
        
            Auth::login($user);
        
            return redirect('/navegar');
      
    }
}
