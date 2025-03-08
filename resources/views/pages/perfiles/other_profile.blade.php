@extends('layouts.app')

{{-- TODO: ARREGLAR ME GUSTAS EN LOS PERFILES--}}
@section('content')
<button  class="rounded-md p-2 flex items-center  gap-5 cursor-pointer bg-[#05324f] text-[#b3e534] translate-x-1 transition-all duration-300 relative top-4 left-3">
<a href="{{route('navegar')}}">
  <i class="fa-solid fa-rocket"></i>
      
  <span class="font-bold max-md:text-md">Navegar</span>

</a>
</button>

<main class="w-[80%] max-md:w-[90%] pt-16 mx-auto">
  
  {{-- Perfil usuario --}}
  <div class="bg-[#05324f] w-full rounded-lg p-6 mb-6 mx-auto flex justify-between">
    {{-- Foto usuario --}}
  <div class="flex gap-10">
    <div>
      <div class="bg-[#05324f] rounded-lg ">
        <img class="w-28 h-28 max-md:w-16 max-md:h-16 rounded-full" src="{{$user->avatar}}" alt="Imagen de {{$user->name}}">
        
      </div>
    </div>
    {{-- Descripción usuario --}}
    <div class="flex flex-col gap-2">
        <h2 class="text-2xl m-0 max-md:text-lg font-semibold mb-1 text-white">{{$user->name}}</h2>
        <a href="{{$user->github_url}}" target="_blank">
        <button class="h-6 w-min p-2 flex items-center gap-2 text-white bg-[#37393d] rounded-sm">
            GitHub
            <i class="fa-brands fa-github"></i>
          </button>
        </a>
    </div>
  </div>
  {{-- Seguidores usuario --}}
  <div class="flex flex-col">
    <div class="flex flex-col text-right">
      <p class="text-white font-bold max-md:text-sm">{{ $user->followers()->count() }}</p>
      <p class="text-md text-[#b3e534] text-opacity-80 max-md:text-xs">Seguidores</p>
    </div>
    <div class="flex flex-col text-right">
      <p class="text-white font-bold max-md:text-sm">{{ $user->following()->count() }}</p>
      <p class="text-md text-[#b3e534] text-opacity-80 max-md:text-xs">Siguiendo</p>
    </div>
    
  </div>
</div>
{{-- Actividades de usuario --}}
<div class="flex gap-3">
  <div class="w-80 max-h-96 bg-[#05324f] rounded-lg p-5 mb-6">
    <h1 class="font-bold text-xl pb-4">Sobre {{$user->name}}</h1>
    <p class="text-white text-md max-md:text-sm break-words ">{{ $user->description }}</p>
  </div>
  <div class="flex-1 max-full mt-16 sm:mt-0">
    <h1 class="font-bold text-2xl pb-4">Sus publicaciones</h1>
    {{-- Posts del usuario --}}
    @if ($posts->count() > 0)
    @foreach ($posts as $post)
        <div class="bg-[#05324f] rounded-lg p-5 mb-6">
            <p class="mb-4 text-white max-md:text-md">{{$post->content}}</p>
            
            
            @if (count($post->media) === 1)
                <section class="w-full h-[350px] mb-4 rounded-md overflow-hidden">
                    @foreach ($post->media as $media)
                        <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full block object-cover" alt="Media de la publicación">
                    @endforeach
                </section>
            @elseif (count($post->media) === 2)
                <section class="w-full h-[390px] mb-4 rounded-md overflow-hidden grid grid-rows-2 gap-1">
                    @foreach ($post->media as $media)
                        <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full block object-cover" alt="Media de la publicación">
                    @endforeach
                </section>
            @elseif (count($post->media) === 3)
                <section class="w-full h-[390px] mb-4 rounded-md overflow-hidden grid grid-cols-3 gap-1">
                    @foreach ($post->media as $index => $media)
                        @if ($index === 0)
                            <div class="col-span-2 row-span-2">
                                <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full object-cover" alt="Media de la publicación">
                            </div>
                        @else
                            <div>
                                <img src="{{ asset('storage/' . $media->path) }}" class="w-full object-cover" alt="Media de la publicación">
                            </div>
                        @endif
                    @endforeach
                </section>
            @endif
            <div class="flex space-x-4 items-center justify-between">
              <div class="flex items-center gap-3">
                <button onclick="toggleLike({{ $post->id }})" class="flex items-center gap-2" id="like-btn-{{ $post->id }}">
                  <span id="like-count-{{ $post->id }}">{{ $post->reaccions->count() }}</span>
                  @if ($post->reaccions->where('user_id', Auth::id())->count())
                      <i id="like-icon-{{ $post->id }}" class="fa-solid fa-heart text-[#b3e534]"></i> 
                  @else
                      <i id="like-icon-{{ $post->id }}" class="fa-regular fa-heart"></i>
                  @endif
                </button>
    
                  <button variant="ghost" size="sm" class="flex items-center gap-2">
                    <span class="">2</span>
                    <i class="fa-solid fa-arrows-rotate"></i>
    
                  </button>
    
                  @if ($post->editado === 1)
                      <span class="text-sm text-gray-400">Editado</span>
                  @endif
              </div>
               <div>
                <span class="bg-[#c7ff3a38] text-slate-200 text-xs font-medium me-2 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-[#c6ff3a]">{{$post->categoria->nombre}}</span>
               </div>
            </div>
        </div>
        @endforeach
    @else
    <div class="w-full text-gray-300 text-center mt-3">El usuario no ha realizado ninguna publicación</div>

    @endif
    
    </div>
</div>


</main>

@endsection


