<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(User $user){
        $currentUser = Auth::user();

        if($currentUser->id == $user->id){
            return redirect()->back()->with('No puede seguirte a tí mismo');
        }

        if(!$currentUser->isFollowing($user)){
            $currentUser->following()->attach($user->id);
            return redirect()->back()->with('success', 'Ahora sigues a ' . $user->name);
        }
        return redirect()->back()->with('info', 'Ya sigues a este usuario.');
    }

    // Dejar de seguir a un usuario
    public function unfollow(User $user) {
        $currentUser = Auth::user();

        if ($currentUser->isFollowing($user)) {
            $currentUser->following()->detach($user->id);
            return redirect()->back()->with('success', 'Has dejado de seguir a ' . $user->name);
        }

        return redirect()->back()->with('info', 'No sigues a este usuario.');
    }
}
