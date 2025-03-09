@extends('layouts.app')


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
        <img class="w-28 h-28 max-md:w-16 max-md:h-16 rounded-full" src="{{filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : Storage::url(Auth::user()->avatar)}}" alt="Imagen de {{Auth::user()->name}}">
        
      </div>
    </div>
    {{-- Descripción usuario --}}
    <div class="flex flex-col gap-2 ">
        <h2 class="text-2xl m-0 max-md:text-lg font-semibold mb-1 text-white">{{(Auth::user()->name)}}</h2>
        <a href="{{Auth::user()->github_url}}" target="_blank">
        <button class="h-6 w-min p-2 flex items-center gap-2 text-white bg-[#37393d] rounded-sm">
            GitHub
            <i class="fa-brands fa-github"></i>
          </button>
        </a>
        
        <button class="h-6 flex gap-2 text-[#b3e534]" variant="outline" size="sm" type="button" onclick="popupEdit()">
          <p class="text-sm">Editar Perfil</p>
          <i class="fa-solid fa-pen text-sm "></i>
        </button>

        

    </div>
  </div>
  {{-- Seguidores usuario --}}
  <div class="flex flex-col">
    <div class="flex flex-col text-right">
      <p class="text-white font-bold max-md:text-sm">{{ Auth::user()->followers()->count() }}</p>
      <p class="text-md text-[#b3e534] text-opacity-80 max-md:text-xs">Seguidores</p>
    </div>
    <div class="flex flex-col text-right">
      <p class="text-white font-bold max-md:text-sm">{{ Auth::user()->following()->count() }}</p>
      <p class="text-md text-[#b3e534] text-opacity-80 max-md:text-xs">Siguiendo</p>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="px-2 py-1 text-md text-white bg-[#be2f2f] rounded-sm mt-3">
        
          Cerrar Sesión
        
        </button>
  </form>
    
  </div>
</div>
{{-- Actividades de usuario --}}
<div class="flex gap-3">
  <div class="w-80 max-h-96 bg-[#05324f] rounded-lg p-5 mb-6">
    <h1 class="font-bold text-xl pb-4">Sobre mí</h1>
    @if (Auth::user()->description > 0)
    <p class="text-white text-md max-md:text-sm break-words ">{{ Auth::user()->description }}</p>
    @else
    <p class="w-full text-sm text-center text-gray-400 mt-2">Agrega una descripción para que los usuarios te conozcan</p>
    @endif
  </div>
  <div class="flex-1 max-full mt-16 sm:mt-0">
    <section class="flex gap-2 justify-center">
      <button  class="rounded-md p-2 flex items-center  gap-5 cursor-pointer bg-[#05324f] text-[#b3e534] translate-x-1 transition-all duration-300 hover:bg-[#1b5f8d]" id="mis-posts">
      
            
        <span class="font-bold max-md:text-md">Mis posts</span>
      
    </button>
      
    <button  class="rounded-md p-2 flex items-center  gap-5 cursor-pointer bg-[#05324f] text-[#b3e534] translate-x-1 transition-all duration-300 hover:bg-[#1b5f8d]" id="mis-reposts">
      
            
      <span class="font-bold max-md:text-md">Reposts</span>
    
  </button>
    </section>
    <div id="mis-posts-container">
      <h1 class="font-bold text-2xl pb-4">Mis publicaciones</h1>
    {{-- Posts del usuario autenticado --}}
    @if ($posts->count() > 0)
    @foreach ($posts as $post)
        <div class="bg-[#05324f] rounded-lg p-5 mb-6">
            <p class="mb-4 text-white max-md:text-md">{{$post->content}}</p>
            
            {{-- Sección de imágenes según la cantidad de media --}}
            @if (count($post->media) === 1)
    <section class="w-full h-[350px] mb-4 rounded-md overflow-hidden">
        @foreach ($post->media as $media)
            @if (Str::startsWith($media->type, 'video'))
                <video class="w-full h-full object-cover" controls>
                    <source src="{{ asset('storage/' . $media->path) }}" type="{{ $media->type }}">
                    Tu navegador no soporta la reproducción de videos.
                </video>
            @else
                <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full block object-cover" alt="Media de la publicación">
            @endif
        @endforeach
    </section>
@elseif (count($post->media) === 2)
    <section class="w-full h-[390px] mb-4 rounded-md overflow-hidden grid grid-cols-2 gap-1">
        @foreach ($post->media as $media)
            <div class="w-full h-full">
                @if (Str::startsWith($media->type, 'video'))
                    <video class="w-full h-full object-cover" controls>
                        <source src="{{ asset('storage/' . $media->path) }}" type="{{ $media->type }}">
                        Tu navegador no soporta la reproducción de videos.
                    </video>
                @else
                    <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full block object-cover" alt="Media de la publicación">
                @endif
            </div>
        @endforeach
    </section>
@elseif (count($post->media) === 3)
    <section class="w-full h-[390px] mb-4 rounded-md overflow-hidden grid grid-cols-3 gap-1">
        @foreach ($post->media as $index => $media)
            @if ($index === 0)
                <div class="col-span-2 row-span-2">
                    @if (Str::startsWith($media->type, 'video'))
                        <video class="w-full h-full object-cover" controls>
                            <source src="{{ asset('storage/' . $media->path) }}" type="{{ $media->type }}">
                            Tu navegador no soporta la reproducción de videos.
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full object-cover" alt="Media de la publicación">
                    @endif
                </div>
            @else
                <div class="w-full h-full">
                    @if (Str::startsWith($media->type, 'video'))
                        <video class="w-full h-full object-cover" controls>
                            <source src="{{ asset('storage/' . $media->path) }}" type="{{ $media->type }}">
                            Tu navegador no soporta la reproducción de videos.
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full object-cover" alt="Media de la publicación">
                    @endif
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
    
                <button onclick="toggleRepost({{ $post->id }})" class="flex items-center gap-2" id="repost-btn-{{ $post->id }}">
                  <span id="repost-count-{{ $post->id }}">{{ $post->reposts->count() }}</span>
                  @if ($post->reposts->where('user_id', Auth::id())->count())
                      <i id="repost-icon-{{ $post->id }}" class="fa-solid fa-arrows-rotate text-[#b3e534]"></i> 
                  @else
                      <i id="repost-icon-{{ $post->id }}" class="fa-solid fa-arrows-rotate"></i>
                  @endif
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
    <div class="w-full text-gray-300 text-center mt-3">Aún no has realizado ninguna publicación</div>
    @endif
    
    
    </div>
    <div id="mis-reposts-container">
      <h1 class="font-bold text-2xl pb-4">Reposts</h1>
    @if ($reposts->count() > 0)
    @foreach ($reposts as $post)
    
        <div class="bg-[#05324f] rounded-lg p-5 mb-6">
          <div class="flex items-start gap-3 mb-3">
            <img class="w-10 h-10 rounded-full" src="{{ filter_var($post->user->avatar, FILTER_VALIDATE_URL) ? $post->user->avatar : Storage::url($post->user->avatar) }}" alt="user photo">
                <div>
                    <h3 class="font-semibold max-md:text-md">{{$post->user->name}}</h3>
                  
                    <p class="text-sm text-gray-400 max-md:text-xs">{{$post->created_at->diffForHumans()}}</p>
                </div>
              </div>
            <p class="mb-4 text-white max-md:text-md">{{$post->content}}</p>
            
            @if (count($post->media) === 1)
    <section class="w-full h-[350px] mb-4 rounded-md overflow-hidden">
        @foreach ($post->media as $media)
            @if (Str::startsWith($media->type, 'video'))
                <video class="w-full h-full object-cover" controls>
                    <source src="{{ asset('storage/' . $media->path) }}" type="{{ $media->type }}">
                    Tu navegador no soporta la reproducción de videos.
                </video>
            @else
                <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full block object-cover" alt="Media de la publicación">
            @endif
        @endforeach
    </section>
@elseif (count($post->media) === 2)
    <section class="w-full h-[390px] mb-4 rounded-md overflow-hidden grid grid-cols-2 gap-1">
        @foreach ($post->media as $media)
            <div class="w-full h-full">
                @if (Str::startsWith($media->type, 'video'))
                    <video class="w-full h-full object-cover" controls>
                        <source src="{{ asset('storage/' . $media->path) }}" type="{{ $media->type }}">
                        Tu navegador no soporta la reproducción de videos.
                    </video>
                @else
                    <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full block object-cover" alt="Media de la publicación">
                @endif
            </div>
        @endforeach
    </section>
@elseif (count($post->media) === 3)
    <section class="w-full h-[390px] mb-4 rounded-md overflow-hidden grid grid-cols-3 gap-1">
        @foreach ($post->media as $index => $media)
            @if ($index === 0)
                <div class="col-span-2 row-span-2">
                    @if (Str::startsWith($media->type, 'video'))
                        <video class="w-full h-full object-cover" controls>
                            <source src="{{ asset('storage/' . $media->path) }}" type="{{ $media->type }}">
                            Tu navegador no soporta la reproducción de videos.
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full object-cover" alt="Media de la publicación">
                    @endif
                </div>
            @else
                <div class="w-full h-full">
                    @if (Str::startsWith($media->type, 'video'))
                        <video class="w-full h-full object-cover" controls>
                            <source src="{{ asset('storage/' . $media->path) }}" type="{{ $media->type }}">
                            Tu navegador no soporta la reproducción de videos.
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-full object-cover" alt="Media de la publicación">
                    @endif
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
    
                <button onclick="toggleRepost({{ $post->id }})" class="flex items-center gap-2" id="repost-btn-{{ $post->id }}">
                  <span id="repost-count-{{ $post->id }}">{{ $post->reposts->count() }}</span>
                  @if ($post->reposts->where('user_id', Auth::id())->count())
                      <i id="repost-icon-{{ $post->id }}" class="fa-solid fa-arrows-rotate text-[#b3e534]"></i> 
                  @else
                      <i id="repost-icon-{{ $post->id }}" class="fa-solid fa-arrows-rotate"></i>
                  @endif
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
    <div class="w-full text-gray-300 text-center mt-3">Aún no has realizado ningún repost</div>
    @endif
    
    
    </div>
    </div>
</div>




             {{-- Pop Up Edit --}}

             <div class="hidden z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="popupEdit-el">
              
              <div class="fixed inset-0 bg-slate-700 bg-opacity-95 transition-opacity" aria-hidden="true"></div>
            
              <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center ">
                  
                  <div class="relative transform overflow-hidden rounded-lg bg-[#05324f] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-[#05324f] px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                      <div class="">
                        
                        <div class="mt-3 text-center  sm:mt-0 sm:text-left">
                          <h3 class="text-md font-semibold text-red-400 pb-2" id="modal-title">Edición de Perfil</h3>
                          
                              <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <p class="text-gray-300 text-md pb-2">Nombre de usuario:</p>
                              <input class="mb-3 w-full bg-[#05324f] resize-none outline-none placeholder:text-gray-400 border-[#1e5072] text-gray-100 text-sm" type="text" name="name" placeholder="https://migithub.com" value="{{Auth::user()->name}}">
                              <p class="text-gray-300 text-md pb-2">Descripción:</p>
                                <textarea
                                rows="8"                                
                                name="description"
                                placeholder="¿Cuáles son tus cualidades?"
                                class="w-full bg-[#05324f] resize-none outline-none placeholder:text-gray-400 border-[#1e5072] text-gray-100 text-sm"
                              >{{Auth::User()->description}}</textarea>
                              <p class="text-gray-300 text-md pb-2">GitHub URL:</p>
                              <input class="mb-3 w-full bg-[#05324f] resize-none outline-none placeholder:text-gray-400 border-[#1e5072] text-gray-100 text-sm" type="text" name="github_url" placeholder="https://migithub.com" value="{{Auth::user()->github_url}}">

                              
                              <p class="text-gray-300 text-md pb-2">Foto de perfil:</p>
                              <input type="file" name="avatar" accept="image/*" class="mb-3 w-full text-sm text-gray-300 bg-[#05324f] border-[#1e5072] cursor-pointer">
                              
                              
                              <button type="submit" class=" inline-flex w-full justify-center rounded-md bg-[#c6ff3a] px-3 py-2 text-sm font-semibold text-[#1f1d1d] shadow-sm sm:ml-3 sm:w-auto">Editar</button>
                                <button type="button" onclick="popupEdit()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
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
            
            {{-- EndPopUP --}}

</main>


<script>
  const popUpEditEl = document.getElementById('popupEdit-el');

   function popupEdit(){
    popUpEditEl.classList.toggle("hidden")
  }


  function toggleLike(postId) {
fetch(`/posts/${postId}/reaccion`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
    }
})
.then(response => response.json())
.then(data => {
    

    document.getElementById(`like-count-${postId}`).textContent = data.count;

    const likeIcon = document.getElementById(`like-icon-${postId}`);
    if (data.liked) {
        likeIcon.classList.remove('fa-regular');
        likeIcon.classList.add('fa-solid', 'text-[#b3e534]');
    } else {
        likeIcon.classList.remove('fa-solid', 'text-[#b3e534]');
        likeIcon.classList.add('fa-regular');
    }
})
.catch(error => console.error('Error:', error));
}

// Repost función
function toggleRepost(postId) {
    fetch(`/posts/${postId}/repost`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById(`repost-count-${postId}`).textContent = data.count;

        const repostIcon = document.getElementById(`repost-icon-${postId}`);
        if (data.reposted) {
            repostIcon.classList.add('text-[#b3e534]');
        } else {
            repostIcon.classList.remove('text-[#b3e534]');
        }
    })
    .catch(error => console.error('Error:', error));
}


// Función que oculta las secciones
document.addEventListener("DOMContentLoaded", function () {
    const misPostsBtn = document.getElementById("mis-posts");
    const misRepostsBtn = document.getElementById("mis-reposts");
    const misPostsDiv = document.getElementById("mis-posts-container");
    const misRepostsDiv = document.getElementById("mis-reposts-container");

    function mostrarSeccion(seccion) {
        if (seccion === "posts") {
            misPostsDiv.style.display = "block";
            misRepostsDiv.style.display = "none";
        } else {
            misPostsDiv.style.display = "none";
            misRepostsDiv.style.display = "block";
        }
    }

    misPostsBtn.addEventListener("click", () => mostrarSeccion("posts"));
    misRepostsBtn.addEventListener("click", () => mostrarSeccion("reposts"));

    // Mostrar "Mis Publicaciones" por defecto
    mostrarSeccion("posts");
});


</script>
@endsection



{{-- 
<div class="mx-auto max-w-52">


  
<form method="POST" action="/profile" enctype="multipart/form-data">
  @csrf
  <label for="website-admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
  <div class="flex ">
    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
      <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
      </svg>
    </span>
    <input name="name" type="text" id="website-admin" class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Bonnie Green">
  </div>

  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
<input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" name="avatar" id="user_avatar" type="file">
<div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="user_avatar_help">Cambiar la foto de tu perfil</div>
<x-primary-button class="w-full shadow-xl py-2.5 px-4 text-sm font-semibold rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none text-center">
  {{ __('Cambiar') }}
</x-primary-button>
</form>
</div>
   --}}
