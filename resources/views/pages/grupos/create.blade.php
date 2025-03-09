@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Crear Grupo</h1>
    <form action="{{ route('groups.store') }}" method="POST" >
        @csrf
        <input type="text" name="title" placeholder="Título" required class="border p-2 w-full mb-2 bg-red-500">
        <textarea name="description" placeholder="Descripción" class="border p-2 w-full mb-2 bg-red-500" ></textarea>
        <select name="categoria_id" class="border p-2 w-full mb-2 bg-red-500" required >
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
        <button class="bg-green-500 text-white px-4 py-2 rounded">Crear</button>
    </form>
@endsection
