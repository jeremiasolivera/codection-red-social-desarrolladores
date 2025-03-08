<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SingleSignOnController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

 


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
    Route::get('/perfil', function(){
        $posts = Post::where('user_id', Auth::id())->latest()->get(); // Filtra los posts del usuario autenticado
     
        return view('pages.perfiles.profile', compact('posts'));
    })->name('profile.change');
    Route::post('/profile', function(Request $request){
        
        $request->validate([
            'name' => 'string|max:100',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();


        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('avatars', 'public');

            $user->avatar = $path;
        }

        $user->save();
        return redirect('dashboard');

    });

    //Editar y eliminar perfil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});


// ****Rutas Posts****
Route::middleware('auth')->group(function(){
    // Route::resource('posts', PostController::class);
    Route::get('/navegar', [PostController::class, 'index'])->name('navegar');
    //Route::get('/post/edit', [PostController::class, 'edit'])->name('post.edit');
    // Rutas de las publicaciones
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::put('/post/edit/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('/posts/{post}/reaccion', [PostController::class, 'reaccion'])->name('posts.reaccion'); 
    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');
    // Rutas de los perfiles
    Route::put('/editar/perfil', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/perfil/{user}', [ProfileController::class, 'show'])->name('profile.show');
});


require __DIR__.'/auth.php';
