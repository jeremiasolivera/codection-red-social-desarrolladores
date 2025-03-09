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
        <img class="w-28 h-28 max-md:w-16 max-md:h-16 rounded-full" src="{{$user->avatar}}" alt="Imagen de {{$user->name}}">
        
      </div>
    </div>
    {{-- Descripción usuario --}}
    <div class="flex flex-col gap-2">
        <h2 class="text-2xl m-0 max-md:text-lg font-semibold mb-1 text-white">{{$user->name}}</h2>
        @if (!empty($user->github_url))
    <a href="{{ $user->github_url }}" target="_blank">
        <button class="h-6 w-min p-2 flex items-center gap-2 text-white bg-[#37393d] rounded-sm">
            GitHub
            <i class="fa-brands fa-github"></i>
        </button>
    </a>
@else
    <button class="h-6 w-min p-2 flex items-center gap-2 text-white bg-gray-500 rounded-sm cursor-not-allowed opacity-50" disabled>
        GitHub
        <i class="fa-brands fa-github"></i>
    </button>
@endif

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
    <section class="flex gap-2 justify-center">
      <button  class="rounded-md p-2 flex items-center  gap-5 cursor-pointer bg-[#05324f] text-[#b3e534] translate-x-1 transition-all duration-300 hover:bg-[#1b5f8d]" id="sus-posts">
      
            
        <span class="font-bold max-md:text-md">Sus posts</span>
      
    </button>
      
    <button  class="rounded-md p-2 flex items-center  gap-5 cursor-pointer bg-[#05324f] text-[#b3e534] translate-x-1 transition-all duration-300 hover:bg-[#1b5f8d]" id="sus-reposts">
      
            
      <span class="font-bold max-md:text-md">Sus reposts</span>
    
  </button>
    </section>
  <div class="flex-1 max-full mt-16 sm:mt-0">
    <div id="sus-posts-container">
        <h1 class="font-bold text-2xl pb-4">Sus publicaciones</h1>
    {{-- Posts del usuario --}}
    @if ($posts->count() > 0)
    @foreach ($posts as $post)
        <div class="bg-[#05324f] rounded-lg p-5 mb-6">
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
    <div class="w-full text-gray-300 text-center mt-3">El usuario no ha realizado ninguna publicación</div>

    @endif
    
    </div>
    {{-- TODO: ARREGLAR BOTONES DE LIKE Y REPOSTS DE ESTA SESIÓN --}}
    <div id="sus-reposts-container">
        <h1 class="font-bold text-2xl pb-4">Sus reposts</h1>
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
                @if ($post->user_id == Auth::id())
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
                </div>
            @endif
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


</main>

<script>
  
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
    //console.log(postId)
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
    const susPostsBtn = document.getElementById("sus-posts");
    const susRepostsBtn = document.getElementById("sus-reposts");
    const susPostsDiv = document.getElementById("sus-posts-container");
    const susRepostsDiv = document.getElementById("sus-reposts-container");

    function mostrarSeccion(seccion) {
        if (seccion === "posts") {
            susPostsDiv.style.display = "block";
            susRepostsDiv.style.display = "none";
        } else {
            susPostsDiv.style.display = "none";
            susRepostsDiv.style.display = "block";
        }
    }

    susPostsBtn.addEventListener("click", () => mostrarSeccion("posts"));
    susRepostsBtn.addEventListener("click", () => mostrarSeccion("reposts"));

    mostrarSeccion("posts");
});


</script>

@endsection


