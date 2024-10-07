<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SingleSignOnController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


 


Route::get('/', function () {
    return view('welcome');
});


//---------------------------------Inicio de sesión con OAuth---------------------------------------

Route::get('/{provider}-auth/redirect', [SingleSignOnController::class, 'singleSignOnRedirect']);

 // Rutas de autenticación con el Provider - Google/Github
Route::get('/{provider}-auth/callback', [SingleSignOnController::class, 'singleSignOnCallback']);
//--------------------------------------------------------------------------------------


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
