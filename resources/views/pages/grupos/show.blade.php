@extends('layouts.app')


@section('content')

<main class="mx-auto px-4 py-8 flex justify-evenly max-md:justify-between ">

   
{{-- Navbar mobile --}}
    <nav class="fixed  sm:hidden w-full z-20 top-0 start-0 shadow-black shadow-md bg-[#05324f] px-5 py-5">
      <ul class="text-[#b3e534] flex justify-between items-center w-full">
        <li class="hover:-translate-y-0.5 transition-all duration-300 "><a href="{{route('navegar')}}" class="text-sm flex items-center gap-2"><i class="fa-solid fa-rocket"></i>Navegar</a></li>
        <li class="hover:-translate-y-0.5 transition-all duration-300 "><a href="{{route('groups.index')}}" class="text-sm flex items-center gap-2">   <i class="fa-solid fa-users-line"></i>Grupos</a></li>
          <li class="hover:-translate-y-0.5 transition-all duration-300 "><a href="{{route('profile.change')}}" class="text-sm flex items-center gap-2"><i class="fa-solid fa-address-card"></i>Perfil</a></li>
      </ul>
    </nav>


    
    {{-- Aside - Perfil --}}
    <aside class="w-64 pr-8 max-md:w-56 max-sm:hidden">
      
      <nav class="space-y-5">
        <button  class="w-full flex items-center  gap-5 cursor-pointer hover:text-[#b3e534] hover:translate-x-1 transition-all duration-300">
            <a href="{{route('navegar')}}">
            <i class="fa-solid fa-rocket"></i>
              
            <span class="font-bold max-md:text-md">Navegar</span>
            </a>
          
        </button>
        <button  class="w-full flex items-center  gap-5 cursor-pointer hover:text-[#b3e534] hover:translate-x-1 transition-all duration-300">
            <a href="{{route('groups.index')}}">
            <i class="fa-solid fa-users-line"></i>
                
                <span class="font-bold max-md:text-md">Grupos</span>
            </a>
          </button>
        <button  class="w-full flex items-center  gap-5 cursor-pointer hover:text-[#b3e534] hover:translate-x-1 transition-all duration-300">
          <a href="{{route('profile.change')}}">

            <i class="fa-solid fa-address-card"></i>
            
            <span class="font-bold max-md:text-md">Perfil</span>
          </a>
        </button>
       
      </nav>


      <aside class="w-full mt-8 block lg:hidden" >
        <div class="bg-[#05324f] bg-opacity-50 rounded-lg p-4 mb-6">
          <h2 class="text-lg max-md:text-md font-semibold mb-4">Proyectos Tendencia</h2>
          <ul class="space-y-2">
            
              <li key={index} class="text-sm max-md:text-xs">
                <a href="#" class="text-cyan-400 hover:underline">React</a>
              </li>
  
              <li key={index} class="text-sm max-md:text-xs">
                <a href="#" class="text-cyan-400 hover:underline">Django</a>
              </li>
  
              <li key={index} class="text-sm max-md:text-xs">
                <a href="#" class="text-cyan-400 hover:underline">Laravel</a>
              </li>
            
          </ul>
        </div>
        <div class="bg-[#05324f] bg-opacity-50 rounded-lg p-4 mb-6">
          <h2 class="text-lg font-semibold mb-4 max-md:text-md">Personas para Seguir</h2>
          <ul class="space-y-4">
  
            @foreach ($group->users as $user)
              <li class="flex items-center gap-2">
                
                <img class="w-8 h-8 rounded-full" src="{{filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : Storage::url($user->avatar)}}" alt="user photo">
                <div class="flex-1">
                  <p class="text-sm font-medium max-md:text-xs ">{{$user->name}}</p>
                </div>
                <button class="bg-[#c6ff3a] hover:bg-[#b3e534] rounded-sm p-1 px-2 text-sm max-md:text-xs text-[#1f1d1d]">
                  Seguir
                </button>
              </li>
            @endforeach
            
              
            
          </ul>
        </div>
        
      </aside>
    </aside>

    {{-- Main content - Input --}}

    

  
    <section class="flex-1 max-w-2xl mt-16  sm:mt-0">
        <div class="bg-[#05324f] rounded-lg p-5 mb-6 space-y-2"> 
            <h2 class="text-xl max-md:text-md font-semibold mb-1 text-[#b3e534]">{{($group->title)}}</h2>
            <p class="text-sm text-gray-300 max-md:text-xs">{{ Str::limit($group->description, 80, '...') }}</p>
          </div>
      <div class="bg-[#05324f] rounded-lg p-4 mb-6">
        {{-- TODO: EL USUARIO EN SESIÓN DEBE ESTAR UNIDO PARA PUBLICAR ALGO --}}
        @if (auth()->check() && auth()->user()->groups->contains($group->id))
        <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="group_id" value="{{ $group->id }}">
    
            <textarea
                rows="4"
                name="content"
                placeholder="¿Qué estás pensando?"
                class="w-full bg-[#05324f] resize-none outline-none placeholder:text-gray-400 border-[#1e5072] text-gray-100 text-sm"
            ></textarea>
    
            <div class="flex justify-between items-end">
                <select name="categoria_id" class="text-sm max-md:text-xs max-md:h-7 max-md:py-1 outline-none w-40 px-2 rounded-sm border-none bg-[#c6ff3a] text-[#1f1d1d] h-8">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
    
                <div class="flex mt-4 gap-3">
                    <input id="fileInput" multiple name="media[]" type="file" class="hidden" />
    
                    <button type="button" onclick="document.getElementById('fileInput').click()" class="cursor-pointer text-[#2e2e2e] bg-[#c6ff3a] hover:bg-[#b3e534] rounded-sm py-1 px-2 text-md">
                        <i class="fa-solid fa-photo-film"></i>
                    </button>
    
                    <input class="max-md:text-xs cursor-pointer bg-[#c6ff3a] hover:bg-[#b3e534] rounded-sm p-1 px-2 text-sm text-[#1f1d1d]" type="submit" value="Publicar"/>
                </div>
            </div>
        </form>
    @else
        <form action="{{ route('groups.join', $group->id) }}" method="POST" class="flex justify-between items-center">
            @csrf
            <p class="text-md text-gray-300">Para subir una publicación debes Unirte: </p>
            <button class="bg-[#b3e534] text-gray-600 px-4 py-2 rounded">Unirse</button>
        </form>
    @endif
    
      </div>

      
      @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert-validator p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
              <span class="font-medium">Algo salió mal!</span> <b>{{$error}}</b>
            </div>
        @endforeach
      @endif
      

      {{-- Posts --}}
      @foreach ($posts as $post)
      <div  class="bg-[#05324f] rounded-lg p-5 mb-6">
          <div class="flex items-center justify-between gap-3 mb-4">
            <div class="flex items-start gap-3">
            <img class="w-10 h-10 rounded-full" src="{{ filter_var($post->user->avatar, FILTER_VALIDATE_URL) ? $post->user->avatar : Storage::url($post->user->avatar) }}" alt="user photo">
                <div>
                    <a href="{{route('profile.show', ['user' => $post->user->id])}}" class="cursor-pointer hover:underline">
                    <h3 class="font-semibold max-md:text-md">{{$post->user->name}}</h3>
                    </a>
                    <p class="text-sm text-gray-400 max-md:text-xs">{{$post->created_at->diffForHumans()}}</p>
                </div>
              </div>
              @can('update', $post)
              <div>
                    <button class="w-6 h-6" variant="outline" size="sm" type="button" onclick="popupEdit()">
                      <i class="fa-solid fa-pen text-sm hover:text-blue-400 transition-all duration-200"></i>
                    </button>
                    
                    <button class="w-6 h-6" variant="outline" onclick="popupDelete()" size="sm">
                      <i class="fa-solid fa-trash text-sm hover:text-red-400 transition-all duration-200"></i>
                    </button>
                    
                  </div>
                @endcan
                
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

            
           
            {{-- Pop Up Delete --}}

            <div class="hidden z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="popupdelete">
              
              <div class="fixed inset-0 bg-slate-700 bg-opacity-95 transition-opacity" aria-hidden="true"></div>
            
              <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                  
                  <div class="relative transform overflow-hidden rounded-lg bg-[#05324f] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-[#05324f] px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                      <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                          <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                          </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                          <h3 class="text-sm font-semibold text-red-400" id="modal-title">¿Seguro que quieres eliminar este Post?</h3>
                          <div class="mt-2">
                            <p class="text-sm text-white">Los usuarios ya no podrán verlo y quedará eliminado de forma permanente de tu historial de posteos.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="bg-[#05324f] px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                      
                            <form action="{{ route('post.destroy', $post) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Eliminar</button>

                            </form>
                          
                      <button type="button" onclick="popupDelete()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            {{-- EndPopUP --}}
           


             {{-- Pop Up Edit --}}

             <div class="hidden z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="popupEdit-el">
              
              <div class="fixed inset-0 bg-slate-700 bg-opacity-95 transition-opacity" aria-hidden="true"></div>
            
              <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center ">
                  
                  <div class="relative transform overflow-hidden rounded-lg bg-[#05324f] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-[#05324f] px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                      <div class="">
                        
                        <div class="mt-3 text-center  sm:mt-0 sm:text-left">
                          <h3 class="text-sm font-semibold text-red-400" id="modal-title">Edición de publicación</h3>
                          
                          <div class="bg-[#05324f] rounded-lg w-full mt-5">
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
                              {{-- <p id="warning-count-img"></p> --}}
                    
                              <button type="button"  onclick="document.getElementById('fileInput-up').click()" class="cursor-pointer text-[#2e2e2e] bg-[#c6ff3a] hover:bg-[#b3e534]rounded-sm py-1 px-3 text-md rounded">
                                <i class="fa-solid fa-plus"></i>
                              </button>
                                
                              
                              
                                
                                <button type="submit" onclick="submitEditForm()" class="inline-flex w-full justify-center rounded-md bg-[#c6ff3a] px-3 py-2 text-sm font-semibold text-[#1f1d1d] shadow-sm sm:ml-3 sm:w-auto">Editar</button>
                                <button type="button" onclick="popupEdit()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                            
                            </div>
                            </div>
                            </form>
                          </div>

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
    </section>
        
    {{-- Right Bar  --}}
    <aside class="w-72 pl-8 max-md:hidden" >
        <div class="bg-[#05324f] bg-opacity-50 rounded-lg p-4 mb-6 flex justify-center">
          <form action="{{ route('groups.leave', $group->id) }}" method="POST">
            @csrf
            <button class="bg-red-500 text-white px-2 py-1 text-lg rounded ">Salir del grupo</button>
            </form>
            
        </div>
        <div class="bg-[#05324f] bg-opacity-50 rounded-lg p-4 mb-6">
          <h2 class="text-lg font-semibold mb-4 max-md:text-md">Personas para Seguir</h2>
          <ul class="space-y-4">
  
            {{-- TODO: Agregar texto cuando no haya personas registradas --}}
            
            @foreach ($users->where('id', '!=', auth()->id())->take(5) as $user)
              <li class="flex items-center gap-2">
                <img class="w-8 h-8 rounded-full" src="{{filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : Storage::url($user->avatar)}}" alt="user photo">
                <div class="flex-1">
                  <p class="text-sm font-medium max-md:text-xs">{{$user->name}}</p>
                  <p class="text-xs text-gray-400">Desarrollador</p>
                </div>
                @if (auth()->user()->isFollowing($user))
                    <form action="{{ route('unfollow', $user->id) }}" method="POST">
                        @csrf
                        <button class="bg-[#c6ff3a] hover:bg-[#b3e534] rounded-sm p-1 px-2 text-sm max-md:text-xs text-[#1f1d1d]">
                          Dejar de Seguir
                        </button>
                    </form>
                @else
                    <form action="{{ route('follow', $user->id) }}" method="POST">
                        @csrf
                        <button class="bg-[#c6ff3a] hover:bg-[#b3e534] rounded-sm p-1 px-2 text-sm max-md:text-xs text-[#1f1d1d]">
                          Seguir
                        </button>
                    </form>
                @endif
               
              </li>
            @endforeach
            
              
            
          </ul>
        </div>
        
      </aside>
        
    </main>

    

@endsection

@section('script')


<script>

  const popUpDelete = document.getElementById('popupdelete');
  const popUpEditEl = document.getElementById('popupEdit-el');



  function popupEdit(){
    popUpEditEl.classList.toggle("hidden")
  }

  function popupDelete(){
    popUpDelete.classList.toggle("hidden")
  }


  // Like función
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

</script>

<script>
alertValidator = document.querySelectorAll("div.alert-validator")

if(alertValidator){
  alertValidator.forEach(el => {
    setTimeout(() => {
        el.style.display = 'none'
      }, 5000);
  });
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



</script> 
@endsection


{{-- 
@foreach ($group->posts as $post)
      <div  class="bg-[#05324f] rounded-lg p-5 mb-6">
          <div class="flex items-center justify-between gap-3 mb-4">
            <div class="flex items-start gap-3">
            <img class="w-10 h-10 rounded-full" src="{{ filter_var($post->user->avatar, FILTER_VALIDATE_URL) ? $post->user->avatar : Storage::url($post->user->avatar) }}" alt="user photo">
                <div>
                    <a href="{{route('profile.show', ['user' => $post->user->id])}}" class="cursor-pointer hover:underline">
                    <h3 class="font-semibold max-md:text-md">{{$post->user->name}}</h3>
                    </a>
                    <p class="text-sm text-gray-400 max-md:text-xs">{{$post->created_at->diffForHumans()}}</p>
                </div>
              </div>
              @can('update', $post)
              <div>
                    <button class="w-6 h-6" variant="outline" size="sm" type="button" onclick="popupEdit()">
                      <i class="fa-solid fa-pen text-sm hover:text-blue-400 transition-all duration-200"></i>
                    </button>
                    
                    <button class="w-6 h-6" variant="outline" onclick="popupDelete()" size="sm">
                      <i class="fa-solid fa-trash text-sm hover:text-red-400 transition-all duration-200"></i>
                    </button>
                    
                  </div>
                @endcan
                
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

</div> <!-- Cierre del div de post -->
@endforeach

--}}