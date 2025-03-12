@extends('layouts.app')

@section('content')


 <div class=" z-10"  >
    
  
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center ">
        
        <div class="relative transform overflow-hidden rounded-lg bg-[#05324f] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
          <div class="bg-[#05324f] px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="">
              
              <div class="mt-3 text-center  sm:mt-0 sm:text-left">
                <h3 class="text-lg font-semibold text-red-400 pb-2">Editar Grupo</h3>
                
                    <form method="POST" action="{{ route('groups.update', $group->id) }}" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <p class="text-gray-300 text-md pb-2">Nombre de grupo:</p>
                    <input class="mb-3 w-full bg-[#05324f] resize-none outline-none placeholder:text-gray-400 border-[#1e5072] text-gray-100 text-sm" type="text" name="title" placeholder="Nuevo Grupo" value="{{ old('name', $group->title) }}">
                    <p class="text-gray-300 text-md pb-2">Descripción:</p>
                      <textarea
                      rows="8"                                
                      name="description"
                      placeholder="¿Cuáles son tus cualidades?"
                      class="w-full bg-[#05324f] resize-none outline-none placeholder:text-gray-400 border-[#1e5072] text-gray-100 text-sm"
                    >{{ old('description', $group->description) }}</textarea>
                    <p class="text-gray-300 text-md pb-2">Categoría:</p>

                    <select name="categoria_id" class="text-sm w-40 px-2 rounded-sm border-none bg-[#c6ff3a] text-[#1f1d1d] h-8 mb-2">
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" 
                                {{ old('categoria_id', $group->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    
                      <br>
                    
                      @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert-validator p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                              <span class="font-medium">Algo salió mal!</span> <b>{{$error}}</b>
                            </div>
                        @endforeach
                      @endif
                    
                    <button type="submit" class=" inline-flex w-full justify-center rounded-md bg-[#c6ff3a] px-3 py-2 text-sm font-semibold text-[#1f1d1d] shadow-sm sm:ml-3 sm:w-auto">Editar</button>
                      <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"><a href="{{route('groups.index')}}">Cancelar</a></button>
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
  
 
@endsection
