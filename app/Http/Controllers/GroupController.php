<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::orderBy('created_at', 'desc')->get();
        return view('pages.grupos.index', compact('groups'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('pages.grupos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id'
        ]);

        $group = Group::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'categoria_id' => $request->categoria_id,
        ]);

        // Agregar al creador automáticamente
        $group->users()->attach(Auth::id());

        return redirect()->route('groups.index')->with('success', 'Grupo creado exitosamente.');
    }

    public function join($id)
    {
        $group = Group::findOrFail($id);
        $group->users()->syncWithoutDetaching([Auth::id()]);

        return redirect()->back()->with('success', 'Te has unido al grupo.');
    }

    public function leave($id)
    {
        $group = Group::findOrFail($id);
        $group->users()->detach(Auth::id());

        return redirect()->back()->with('success', 'Has salido del grupo.');
    }

    public function show(Group $group)
    {
        
        $group->load(['categoria']);
        $posts = Post::with('reaccions')
        ->where('group_id', $group->id) 
        ->orderBy('created_at', 'desc')
        ->get();
        $categorias = Categoria::all();
        $users = User::all();

        return view('pages.grupos.show', compact('group','categorias','users','posts'));
    }

    
}
