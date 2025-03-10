@extends('layouts.app')

{{-- TODO: RESPONSIVE VISTAS GRUPOS Y PERFILES, PAGINA PRINCIPAL Y LOGINS, LOGO Y NOMBRE DE PÁGINAS --}}

@section('content')
<button  class="rounded-md p-2 flex items-center  gap-5 cursor-pointer bg-[#05324f] text-[#b3e534] translate-x-1 transition-all duration-300 relative top-4 left-3">
<a href="{{route('navegar')}}">
  <i class="fa-solid fa-rocket"></i>
      
  <span class="font-bold max-md:text-md">Navegar</span>

</a>
</button>


<main class="w-[80%] max-md:w-[90%] pt-16 mx-auto">
  
  {{-- Grupos --}}
  

 <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold mb-4">Grupos Disponibles</h1>
    <a href="{{ route('groups.create') }}" class="bg-[#b3e534]  text-gray-700 px-4 py-2 rounded">Crear Grupo</a>
 </div>
  <ul class="mt-4">
      @foreach($groups as $group)
          <li class="p-4 border-b flex justify-between">
              <div >
                <div class="hover:translate-x-1 transition-all duration-200">

                    <a href="{{route('groups.show', ['group' => $group->id])}}">
                        <h2 class="text-xl font-semibold text-[#b3e534]">{{ $group->title }}</h2>
                        <p class="text-md w-96 my-1">{{ $group->description }}</p>
                        <p class="text-gray-400 text-sm">Categoría: {{ $group->categoria->nombre }}</p>
                    </a>
                </div>
                @if(auth()->check() && auth()->user()->id === $group->user_id)
                    <div class="flex items-center justify-start gap-2">
                        <form action="{{ route('groups.destroy', $group->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 text-md rounded">
                                <i class="fa-solid fa-trash  hover:text-red-400 transition-all duration-200"></i>
                            </button>
                        </form>
                        <a href="{{route('groups.edit',  $group->id)}}">
                            <button class="bg-blue-500 text-white px-2 py-[0.26rem] text-md rounded translate-y-1">
                                <i class="fa-solid fa-pen  hover:text-blue-400 transition-all duration-200"></i>
                            </button>
                        </a>
                    </div>
                @endif
              </div>
              @if (!$group->users->contains(Auth::id()))
                  <form action="{{ route('groups.join', $group->id) }}" method="POST">
                      @csrf
                      <button class="bg-[#348fe5]  text-white px-4 py-2 rounded">Unirse</button>
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





  </div>


</main>

@endsection





