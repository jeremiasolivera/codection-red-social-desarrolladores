<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Categoria;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use LengthException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
            'categoria_id' => 'required|exists:categorias,id',
            'group_id' => 'nullable|exists:groups,id' 
        ]);
        
    

        $post = Post::create([
            'user_id' => Auth::id(), 
            'content' => $request->content,
            'categoria_id' => $request->categoria_id,
            'group_id' => $request->group_id
        ]);
        

        if ($request->has('media') && $request->has('media') <= 3) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('media', 'public'); 
                $type = $file->getMimeType();
    
                $post->media()->create([
                    'type' => $type,
                    'path' => $path,
                ]);
            }
        }else{
            return redirect()->back()->with('success', 'El posts se subió correctamente.');
            
        }

        return redirect()->back()->with('success', 'El posts se subió correctamente.');

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

        $cantidadActual = $post->media()->count(); // Cuenta cuántas imágenes ya subió
        $disponibles = 3 - $cantidadActual; // Espacios restantes
        
        $request->validate([
            'content' => 'required|string',
            'media' => 'array|max:' . $disponibles,
            'media.*' => 'image|max:2048', // Validación de imágenes
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        if ($disponibles <= 0) {
            return redirect()->back()->with('error', 'Ya alcanzaste el límite de imágenes permitidas.');
        }

        // Actualiza el contenido de la publicación
        $post->content = $request->content;
        $post->categoria_id = $request->categoria_id;

        // Procesa las imágenes si hay nuevas
        if ($request->hasFile('media')) {
            
            // Elimina las imágenes antiguas
            // foreach ($post->media as $filePath) {
            //     $filePath->delete();
            //     Storage::delete($filePath);
            // }

            // Guarda las nuevas imágenes y almacena las rutas
            $mediaPaths = [];

            foreach ($request->file('media') as $file) {
                $path = $file->store('media', 'public'); 
                $type = $file->getMimeType();
                $mediaPaths[] = $path;

                
                $post->media()->create([
                    'type' => $type,
                    'path' => $path,
                ]);
                #$post->media = $mediaPaths;
                #$post->type = $type;
            }

            
        }
        ##dd($post);

        $post->save();

        return redirect()->route('profile.change')->with('success', 'Post actualizado correctamente.');

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

        return redirect()->back()->with('success', 'Post eliminado correctamente.');

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

 //Repost método
 public function repost(Request $request, $id)
 {
     $post = Post::findOrFail($id);
     $user = Auth::user();
 
     $repost = $post->reposts()->where('user_id', $user->id)->first();
 
     if ($repost) {
         $repost->delete();
         $reposted = false;
     } else {
         $post->reposts()->create(['user_id' => $user->id]);
         $reposted = true;
     }
 
     return response()->json([
         'count' => $post->reposts()->count(),
         'reposted' => $reposted,
     ]);
 }
 


}


