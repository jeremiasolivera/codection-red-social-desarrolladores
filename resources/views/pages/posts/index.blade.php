@extends('layouts.app')


@section('content')
<main class="container mx-auto px-4 py-8 flex justify-evenly">
    
    {{-- Aside - Perfil --}}
    <aside class="w-64 pr-8 sticky">
      <div class="bg-[#05324f] rounded-lg p-5 mb-6 space-y-2">
        <img class="w-16 h-16 rounded-full" src="{{filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : Storage::url(Auth::user()->avatar)}}" alt="user photo">
        <h2 class="text-lg font-semibold mb-1 text-white">{{(Auth::user()->name)}}</h2>
        <p class="text-sm text-gray-300">Full-stack developer passionate about React and Node.js</p>
      </div>
      <nav class="space-y-5">
        <button  class="w-full flex items-center  gap-5 cursor-pointer hover:text-[#b3e534] hover:translate-x-1 transition-all duration-300">
          <i class="fa-solid fa-rocket"></i>
              
            <span class="font-bold ">Navegar</span>
          
        </button>
        <button  class="w-full flex items-center  gap-5 cursor-pointer hover:text-[#b3e534] hover:translate-x-1 transition-all duration-300">
          <i class="fa-solid fa-users-line"></i>
              
              <span class="font-bold ">Grupos</span>
        </button>
        <button  class="w-full flex items-center  gap-5 cursor-pointer hover:text-[#b3e534] hover:translate-x-1 transition-all duration-300">
            <i class="fa-solid fa-address-card"></i>
              
              <span class="font-bold ">Perfil</span>
        </button>
       
      </nav>
    </aside>

    {{-- Main content - Input --}}

  
    <section class="flex-1 max-w-2xl">
      <div class="bg-[#05324f] rounded-lg p-4 mb-6">
        <form method="POST" action="{{route('post.store')}}" enctype="multipart/form-data">
          @csrf
          <textarea
          rows="4"
          name="content"
          placeholder="¿Qué estás pensando?"
          class="w-full bg-[#05324f] resize-none outline-none placeholder:text-gray-400 border-[#1e5072] text-gray-100 text-sm"
        ></textarea>

        <div class="flex justify-between items-end">
          <select name="categoria_id" class="text-sm outline-none w-40 px-2 rounded-sm border-none bg-[#c6ff3a] text-[#1f1d1d] h-8"  >
            @foreach ($categorias as $categoria)
                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
            @endforeach
          </select>
        
        
        <div class="flex  mt-4 gap-3">
          
          <input id="fileInput" multiple name="media[]" type="file" class="hidden" />

          <button type="button"  onclick="document.getElementById('fileInput').click()" class="cursor-pointer text-[#2e2e2e] bg-[#c6ff3a] hover:bg-[#b3e534]rounded-sm py-1 px-2 text-md rounded">
            <i class="fa-solid fa-photo-film"></i>
          </button>
            
          
          <input class="cursor-pointer bg-[#c6ff3a] hover:bg-[#b3e534] rounded-sm p-1 px-2 text-sm text-[#1f1d1d]" variant="outline" size="sm" type="submit" value="Publicar"/>
            
        </div>
        </div>
        </form>
      </div>
      
      {{-- Posts --}}
      @foreach ($posts as $post)
      <div  class="bg-[#05324f] rounded-lg p-5 mb-6">
          <div class="flex items-center justify-between gap-3 mb-4">
            <div class="flex items-start gap-3">
            <img class="w-10 h-10 rounded-full" src="{{ filter_var($post->user->avatar, FILTER_VALIDATE_URL) ? $post->user->avatar : Storage::url($post->user->avatar) }}" alt="user photo">
                <div>
                    <h3 class="font-semibold">{{$post->user->name}}</h3>
                    <p class="text-sm text-gray-400">{{$post->created_at->diffForHumans()}}</p>
                </div>
              </div>
              @can('update', $post)
              <div>
                    <a href="{{route('post.edit')}}" class="w-6 h-6" variant="outline" size="sm">
                      <i class="fa-solid fa-pen text-sm hover:text-blue-400 transition-all duration-200"></i>
                    </a>
                    
                        <button class="w-6 h-6" variant="outline" onclick="popupDelete()" size="sm">
                          <i class="fa-solid fa-trash text-sm hover:text-red-400 transition-all duration-200"></i>
                        </button>
                    
                  </div>
                @endcan
                
            </div>
            <p class="mb-4 text-white">{{$post->content}}</p>
            
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

           
            {{-- Pop Up Delete --}}

            <div class="hidden z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="popupdelete">
              
              <div class="fixed inset-0 bg-slate-700 bg-opacity-80 transition-opacity" aria-hidden="true"></div>
            
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
                          <h3 class="text-base font-semibold text-red-400" id="modal-title">¿Seguro que quieres eliminar este Post?</h3>
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
    </section>
        
    {{-- Right Bar  --}}
    <aside class="w-72 pl-8" >
      <div class="bg-[#05324f] bg-opacity-50 rounded-lg p-4 mb-6">
        <h2 class="text-lg font-semibold mb-4">Proyectos Tendencia</h2>
        <ul class="space-y-2">
          
            <li key={index} class="text-sm">
              <a href="#" class="text-cyan-400 hover:underline">React</a>
            </li>

            <li key={index} class="text-sm">
              <a href="#" class="text-cyan-400 hover:underline">Django</a>
            </li>

            <li key={index} class="text-sm">
              <a href="#" class="text-cyan-400 hover:underline">Laravel</a>
            </li>
          
        </ul>
      </div>
      <div class="bg-[#05324f] bg-opacity-50 rounded-lg p-4 mb-6">
        <h2 class="text-lg font-semibold mb-4">Personas para Seguir</h2>
        <ul class="space-y-4">

          @foreach ($users as $user)
            <li class="flex items-center gap-2">
              <img class="w-8 h-8 rounded-full" src="{{filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : Storage::url($user->avatar)}}" alt="user photo">
              <div class="flex-1">
                <p class="text-sm font-medium">{{$user->name}}</p>
                <p class="text-xs text-gray-400">Desarrollador</p>
              </div>
              <button class="bg-[#c6ff3a] hover:bg-[#b3e534] rounded-sm p-1 px-2 text-sm text-[#1f1d1d]">
                Seguir
              </button>
            </li>
          @endforeach
          
            
          
        </ul>
      </div>
      <div class="bg-[#05324f] bg-opacity-50 rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-4">Actividad Reciente</h2>
        <ul class="space-y-2 text-sm">
          <li>Usuario1 comentó en tu publicación</li>
          <li>Usuario2 le gustó tu proyecto</li>
          <li>Usuario3 compartió tu artículo</li>
        </ul>
      </div>
    </aside>
        
    </main>

    

@endsection

@section('script')
<script>

  const popUpDelete = document.getElementById('popupdelete');

  function popupDelete(){
    popUpDelete.classList.toggle("hidden")
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

</script>
@endsection