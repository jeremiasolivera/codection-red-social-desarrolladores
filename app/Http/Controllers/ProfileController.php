<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request)
{
    $request->validate([
        'description' => 'max:500',
        'github_url' => 'nullable|url|max:255',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        'name' => 'nullable|max:20', 
    ]);

    $user = Auth::user();

    
    if ($request->hasFile('avatar')) {
        // Elimina la imagen anterior si existe
        if ($user->avatar) {
            Storage::delete('public/' . $user->avatar);
        }

        // Guarda la nueva imagen
        $file = $request->file('avatar');
        $path = $file->store('media', 'public');
        $type = $file->getMimeType();

        // Actualiza la imagen en la BD
        $user->avatar = $path;
    }

    
    $user->update([
        'description' => $request->input('description'),
        'github_url' => $request->input('github_url'),
        'name' => $request->input('name'),
        'avatar' => $user->avatar ?? $user->avatar, 
    ]);

    return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
}


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show(User $user){
        $posts = Post::where('user_id', $user->id)->latest()->get();
        $reposts = Post::whereHas('reposts', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('user')
        ->latest()
        ->get();
        return view('pages.perfiles.other_profile', compact('user','posts','reposts'));
    }
}
