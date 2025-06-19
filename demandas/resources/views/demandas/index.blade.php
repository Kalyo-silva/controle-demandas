<x-app-layout>

    @if (session('success'))
        <div class="flex items-center mx-auto  mt-8 p-2 border border-green-800 w-fit bg-green-100 text-green-800 rounded">
            <p>{{session('success')}}</p>
            <img onclick="this.parentElement.style.display = 'none';" src="{{asset('img'.DIRECTORY_SEPARATOR.'close-green.svg')}}" class="size-6 ml-2 cursor-pointer" alt="">
        </div>
    @endif

    <div class="py-12 pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div class='flex items-center'>
                            <img src="{{asset('img'.DIRECTORY_SEPARATOR.'demanda.svg')}}" class="size-8 mr-2 cursor-pointer" alt="">
                            <h1 class="text-xl font-bold">Minhas Demandas</h1>
                        </div>
                        
                        <div class="flex items-start">
                            <a href="{{route('demandas.create')}}"
                               class="bg-blue-700 hover:bg-blue-900 px-4 py-2 rounded text-white">
                               Novo
                            </a>
                            
                            <form class="flex items-end flex-col"
                                  action="{{route('demandas.search')}}">
                                <div class="flex items-center border border-gray-700 rounded ml-4 focus:border-blue-400">
                                    <button type="submit">
                                        <img src="{{asset('img'.DIRECTORY_SEPARATOR.'search.svg')}}" class="size-6 ml-2 cursor-pointer" alt="Search">
                                    </button>
                                    <input value="{{$searchString}}" id='Search' class="rounded py-1 border-white focus:border-white focus:ring-0" type="text" name="search">
                                    
                                    @if ($searchString != '')
                                        <a href="{{url('demandas')}}">
                                            <img src="{{asset('img'.DIRECTORY_SEPARATOR.'clear.svg')}}" 
                                                class="size-6 mr-2 cursor-pointer opacity-50" alt="clear">
                                        </a>
                                    @endif
                                </div>
                                <div>
                                    <label for="concluido">Demandas Concluidas</label>
                                    <input type="checkbox" name="concluido" class="rounded" @if ($concluido == true) checked @endif>
                                </div>
                                <div>
                                    <label for="todos">Todos os Usuários</label>
                                    <input type="checkbox" name="todos" class="rounded" @if ($todos == true) checked @endif>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    @if (!$listaDemandas->isEmpty())
                        <div class="grid grid-cols-3 gap-4 my-6">
                            @foreach ($listaDemandas as $demanda)
                                <a href="{{route("demandas.show", $demanda->id)}}">
                                    <div class="border 
                                                group 
                                                border-gray-300 
                                                rounded 
                                                p-4 
                                                h-full
                                                transition-all 
                                                cursor-pointer 
                                                hover:border-blue-700
                                                flex
                                                flex-col
                                                justify-between">
                                        <div class="flex transition-all whitespace-nowrap justify-between border-b-2 border-b-gray-700 group-hover:border-b-blue-700 mb-2">
                                            <h3 class="font-bold overflow-hidden text-ellipsis max-w-44">{{$demanda->titulo}}</h3>
                                            
                                            <div class="flex ml-2">
                                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'client.svg')}}" alt="user" class="h-5">
                                                <h3 class="">{{$demanda->Cliente->nome}}</h3>
                                            </div>
                                        </div>
                                        
                                        <textarea readonly class="w-full bg-gray-300 rounded" rows="6">{{$demanda->Tramites->last()->complemento}}</textarea>

                                        <div class="flex justify-between mt-1">
                                            <div class="flex">
                                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'calendar.svg')}}" alt="user" class="h-5 mr-1">
                                                <h3>{{Date('d/m/Y H:i',strToTime($demanda->Tramites->last()->data_tramite))}}</h3>
                                            </div>
                                            <p class="text-gray-400 italic">{{$demanda->Tramites->count()}} Trâmite(s)</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="p-6 w-full text-center">Nenhum Registro Encontrado...</p>
                    @endif
                    
                    <div>
                        {{ $listaDemandas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
