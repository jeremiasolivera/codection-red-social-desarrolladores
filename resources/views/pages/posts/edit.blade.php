@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Editar Publicación</h1>

    <!-- Formulario para editar la publicación -->
    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Campo de contenido -->
        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-bold mb-2">Contenido:</label>
            <textarea id="content" name="content" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('content', $post->content) }}</textarea>
        </div>

        <!-- Campo para actualizar imágenes -->
        <div class="mb-4">
            <label for="media" class="block text-gray-700 font-bold mb-2">Imágenes:</label>
            <input type="file" id="media" name="media[]" multiple class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            <small class="text-gray-500">Puedes cargar hasta 3 imágenes.</small>
        </div>

        <!-- Mostrar imágenes actuales -->
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Imágenes Actuales:</label>
            <div class="flex space-x-4">
                @foreach ($post->media as $media)
                    <img src="{{ asset('storage/' . $media->path) }}" alt="Media de la publicación">
                @endforeach
            </div>
        </div>

        <!-- Botón de enviar -->
        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Actualizar Publicación
            </button>
            <a href="{{ route('posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-4">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
