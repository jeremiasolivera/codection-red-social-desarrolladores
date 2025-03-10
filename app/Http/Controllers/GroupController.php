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
        $misgroups = Group::where('user_id', Auth::id())->get();

        return view('pages.grupos.index', compact('groups','misgroups'));
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
            'title' => 'required|string|max:55',
            'description' => 'nullable|string|max:100',
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

    public function destroy(Group $group)
    {
        if (auth()->user()->id !== $group->user_id) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar este grupo.');
        }

        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Grupo eliminado correctamente.');
    }

    public function edit(Group $group)
    {
        if (auth()->user()->id !== $group->user_id) {
            return redirect()->back()->with('error', 'No tienes permiso para editar este grupo.');
        }
        $categorias = Categoria::all();


        return view('pages.grupos.edit', compact('group','categorias'));
    }

    public function update(Request $request, Group $group)
    {
        if (auth()->user()->id !== $group->user_id) {
            return redirect()->back()->with('error', 'No tienes permiso para actualizar este grupo.');
        }

        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:100',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $group->update([
            'title' => $request->title,
            'description' => $request->description,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('groups.show', $group->id)->with('success', 'Grupo actualizado correctamente.');
    }
    
}
