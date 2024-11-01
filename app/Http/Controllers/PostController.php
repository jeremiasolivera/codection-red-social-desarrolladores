<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Categoria;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('reaccions')->orderBy('created_at', 'desc')->get();
        $users = User::all();
        $categorias = Categoria::all();
        return view('pages.posts.index', compact('posts','users','categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.posts.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'content' => 'required|string|max:255',
            'media' => 'array|max:3',
            'media.*' => 'file|mimes:jpeg,jpg,png,webp,mp4|max:10240',
            'categoria_id' => 'required|exists:categorias,id' 
        ]);
        
    

        $post = Post::create([
            'user_id' => Auth::id(), 
            'content' => $request->content,
            'categoria_id' => $request->categoria_id
        ]);
        

        if ($request->has('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('media', 'public'); 
                $type = $file->getMimeType();
    
                $post->media()->create([
                    'type' => $type,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('navegar');

    }

    

    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categorias = Categoria::all();
        $this->authorize('update', $post);

        return view('pages.posts.edit', compact('post','categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'content' => 'required|string|max:255',
            'media' => 'array|max:3',
            'media.*' => 'file|mimes:jpeg,jpg,png,webp,mp4|max:10240'

        ]);

        

        $post->content = $request->content;
        $post->editado = 1;

        if ($request->has('media')) {
            foreach ($post->media as $media) {
                Storage::delete($media->path); // Usa el nombre correcto del campo donde guardas la ruta del archivo

                // Elimina el registro de la tabla media
                $media->delete();
            }

            foreach ($request->file('media') as $file) {
                $path = $file->store('media', 'public'); 
                $type = $file->getMimeType();
    
                $post->media()->create([
                    'type' => $type,
                    'path' => $path,
                    
                ]);
            }
        }

        $post->save();

        return redirect()->route('navegar')->with('success', 'Publicación actualizada exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if(auth()->id() !== $post->user_id){
            return redirect()->back()->with('error', 'No tienes permisos para eliminar este post');
        }

        $post->delete();

        return redirect()->route('navegar')->with('success', 'Publicación eliminada correctamente');

    }

    //***************Extras******************* */

    public function reaccion(Request $request, $id)
{
    $post = Post::findOrFail($id);
    $user = Auth::user();

    $reaction = $post->reaccions()->where('user_id', $user->id)->first();

    if ($reaction) {
        $reaction->delete();
        $liked = false;
    } else {
        $post->reaccions()->create(['user_id' => $user->id]);
        $liked = true;
    }

    return response()->json([
        'count' => $post->reaccions()->count(),
        'liked' => $liked,
    ]);
}

}
