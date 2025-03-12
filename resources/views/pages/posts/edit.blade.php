@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class=" z-10"  >
    
  
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center ">
            
            <div class="relative transform overflow-hidden rounded-lg bg-[#05324f] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
              <div class="bg-[#05324f] px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="">
                  
                  <div class="mt-3 text-center  sm:mt-0 sm:text-left">
                    <h3 class="text-lg font-semibold text-red-400 pb-2">Editar Publicacion</h3>
                    
                          
                          <!-- Formulario para editar la publicación -->
    <form method="POST" action="{{route('post.update', $post)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <textarea
        rows="4"
        name="content"
        placeholder="¿Qué estás pensando?"
        class="w-full bg-[#05324f] resize-none outline-none placeholder:text-gray-400 border-[#1e5072] text-gray-100 text-sm"
      >{{$post->content}}</textarea>

      <div class="flex gap-2 justify-start">
      @foreach($post->media as $image)
        <div class="w-20 h-20 rounded-sm overflow-hidden ">
          @if (Str::startsWith($image->type, 'video'))
          <video class="w-full h-full object-cover" controls>
              <source src="{{ asset('storage/' . $image->path) }}" type="{{ $image->type }}">
              Tu navegador no soporta la reproducción de videos.
          </video>
          @else
          <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover" alt="Media de la publicación">
          @endif
        </div>
        @endforeach
      </div>

      <div class="flex justify-between items-end">
        <select name="categoria_id" class="text-sm max-md:text-xs max-md:h-7 max-md:py-1 outline-none w-40 px-2 rounded-sm border-none bg-[#c6ff3a] text-[#1f1d1d] h-8"  >
          @foreach ($categorias as $categoria)
              <option value="{{$categoria->id}}" selected='{{$post->categoria}}'>{{$categoria->nombre}}</option>
          @endforeach
        </select>
      
        
      
      <div class="flex  mt-4 gap-3">
        
        
        <input id="fileInput-up" multiple name="media[]" type="file" class="hidden" />

        <button type="button"  onclick="document.getElementById('fileInput-up').click()" class="cursor-pointer text-[#2e2e2e] bg-[#c6ff3a] hover:bg-[#b3e534]rounded-sm py-1 px-3 text-md rounded">
          <i class="fa-solid fa-plus"></i>
        </button>
          
        
        
          
          <button type="submit"  class="inline-flex w-full justify-center rounded-md bg-[#c6ff3a] px-3 py-2 text-sm font-semibold text-[#1f1d1d] shadow-sm sm:ml-3 sm:w-auto">Editar</button>
          <a href="{{route('profile.change')}}" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</a>
      
      </div>
      </div>
      </form>
                     
    
                  </div>
                </div>
              </div>
              <div class="bg-[#05324f] px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                
                      
                    
               
              </div>
            </div>
          </div>
        </div>
      </div>

    
</div>
@endsection
