<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center border-b pb-2 border-gray-900/10">
                        <div class='flex items-center'>
                            <img src="{{asset('img'.DIRECTORY_SEPARATOR.'demanda-alterar.svg')}}" class="size-8 mr-2 cursor-pointer" alt="">
                            <h1 class="text-xl font-bold">Editar Demanda</h1>
                        </div>
                    </div>
                    
                    <form class="mt-5" action="{{route('demandas.update', $demanda->id)}}" enctype="multipart/form-data"  method="POST">
                    @method('PUT')
                    @csrf
                        <div class="flex">
                            <div class="flex flex-col mb-4 w-full">
                                <label for="titulo">Titulo</label>
                                <input placeholder="Titulo da Demanda..." 
                                    class="rounded border-gray-300" 
                                    type="text"
                                    name="titulo" 
                                    id="titulo"
                                    value="{{$demanda->titulo}}"              
                                >
                            </div>
                            
                            <div class="flex flex-col ml-4">
                                <label for="datetime-local">Data Abertura</label>
                                <input class="rounded border-gray-300"
                                    type="date"
                                    value="{{date('Y-m-d', strToTime($demanda->data_abertura))}}"
                                    readonly>
                            </div>
                        </div>
                        
                        <div class="flex">
                            <div class="flex flex-col mb-4 mr-4 w-full">
                                <label for="user_id_atual">Usuário Responsável</label>
                                <select name="user_id_atual" id="user_id_atual" class="select2" readonly>
                                    <option value="{{$demanda->userAbertura->id}}">{{$demanda->userAbertura->name}}</option>      
                                </select>
                            </div>
                            <div class="flex flex-col w-full">
                                <label for="cliente_id">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="select2">
                                    <option value="0">Selecione...</option>
                                    @foreach ($listaClientes as $cliente)
                                        @if ($cliente->id == $demanda->Cliente->id)
                                            <option value="{{$cliente->id}}" selected>{{$cliente->nome}}</option>
                                        @else
                                            <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                        @endif                                            
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end mt-2">
                            <a href="{{route('demandas.index')}}" class="px-4 py-2 text-red-700 ring-1 ring-red-700 hover:bg-red-900 rounded hover:text-white">Cancelar</a>
                            <button class="px-4 py-2 text-green-700 ring-1 ring-green-700 hover:bg-green-900 rounded hover:text-white ml-2" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>