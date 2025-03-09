@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Grupos</h1>
    <a href="{{ route('groups.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Crear Grupo</a>
    <ul class="mt-4">
        @foreach($groups as $group)
            <li class="p-4 border-b flex justify-between">
                <div>
                    <a href="{{route('groups.show', ['group' => $group->id])}}">
                    <h2 class="text-xl font-semibold">{{ $group->title }}</h2></a>
                    <p>{{ $group->description }}</p>
                    <p class="text-gray-600">Categoría: {{ $group->categoria->nombre }}</p>
                </div>
                @if (!$group->users->contains(Auth::id()))
                    <form action="{{ route('groups.join', $group->id) }}" method="POST">
                        @csrf
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">Unirse</button>
                    </form>
                @else
                    <form action="{{ route('groups.leave', $group->id) }}" method="POST">
                        @csrf
                        <button class="bg-red-500 text-white px-4 py-2 rounded">Salir</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
@endsection
