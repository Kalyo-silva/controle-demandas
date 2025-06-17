<x-app-layout>

    @if (session('success'))
        <div class="flex items-center mx-auto  mt-8 p-2 border border-green-800 w-fit bg-green-100 text-green-800 rounded">
            <p>{{session('success')}}</p>
            <img onclick="this.parentElement.style.display = 'none';" src="{{asset('img'.DIRECTORY_SEPARATOR.'close-green.svg')}}" class="size-6 ml-2 cursor-pointer" alt="">
        </div>
    @endif

    <div class="py-12 pt-8">
        <div class="flex max-w-7xl mx-auto overflow-hidden sm:px-6 lg:px-8">
            {{-- Sidebar Ações --}}
            <div class="bg-white rounded-lg p-6 flex flex-col justify-between">
                
                @if ($demanda->situacao == 1 )
                    <div class="border p-2 rounded border-green-700 mb-2 w-full flex">
                        <img src="{{asset('img'.DIRECTORY_SEPARATOR.'check-green.svg')}}" class="size-6 mr-2" alt="">
                        <p class="text-green-700">Demanda Concluida</p>
                    </div>
                    
                    <form method="POST" action="{{route('demandas.concluir', $demanda->id)}}">
                        @csrf
                        @method('PUT')
                        <button type='submit' class="border p-2 rounded border-blue-700 mb-2 w-full flex cursor-pointer hover:bg-blue-100">
                            <img src="{{asset('img'.DIRECTORY_SEPARATOR.'redo-blue.svg')}}" class="size-6 mr-2" alt="">
                            <p class="text-blue-700">Reabrir Demanda</p>
                        </button>
                    </form>
                @else
                    <div>                    
                        @if (Auth::id() == $demanda->user_id || Auth::id() == $demanda->Tramites->last()->user_id_tramitado)
                            <a href="{{route('demandas.tramitar', $demanda->id)}}">
                                <div class="border p-2 rounded border-black mb-2 cursor-pointer flex hover:bg-gray-200">
                                    <img src="{{asset('img'.DIRECTORY_SEPARATOR.'send.svg')}}" class="size-6 mr-2" alt="">
                                    <p>Tramitar</p>
                                </div>
                            </a>
                            
                            <a href="{{route('demandas.complemento', $demanda->id)}}">
                                <div class="border p-2 rounded border-black mb-2 cursor-pointer flex hover:bg-gray-200">
                                    <img src="{{asset('img'.DIRECTORY_SEPARATOR.'notes.svg')}}" class="size-6 mr-2" alt="">
                                    <p>Complemento</p>
                                </div>
                            </a>
                            
                            <a href="{{route('demandas.edit', $demanda->id)}}">
                                <div class="border p-2 rounded border-black mb-2 cursor-pointer flex hover:bg-gray-200">
                                    <img src="{{asset('img'.DIRECTORY_SEPARATOR.'edit.svg')}}" class="size-6 mr-2" alt="">
                                    <p>Editar</p>
                                </div>
                            </a>
                        @else
                            <a href="{{route('demandas.complemento', $demanda->id)}}">
                                <div class="border p-2 rounded border-black mb-2 cursor-pointer flex hover:bg-gray-200">
                                    <img src="{{asset('img'.DIRECTORY_SEPARATOR.'notes.svg')}}" class="size-6 mr-2" alt="">
                                    <p>Complemento</p>
                                </div>
                            </a>                        
                        @endif
                    </div>

                    @if (Auth::id() == $demanda->user_id || Auth::id() == $demanda->Tramites->last()->user_id_tramitado)    
                        <div>
                            <form method="POST" action="{{route('demandas.concluir', $demanda->id)}}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="border p-2 rounded border-green-700 mb-2 w-full cursor-pointer flex hover:bg-green-100">
                                    <img src="{{asset('img'.DIRECTORY_SEPARATOR.'check-green.svg')}}" class="size-6 mr-2" alt="">
                                    <p class="text-green-700">Concluir</p>
                                </button>
                            </form>

                            <form method="POST" action="{{route('demandas.destroy', $demanda->id)}}">
                                @csrf
                                @method('DELETE')
                                <div onclick="ModalDelete(this)" class="border p-2 rounded border-red-700 cursor-pointer flex hover:bg-red-100">
                                    <img src="{{asset('img'.DIRECTORY_SEPARATOR.'trash-red.svg')}}" class="size-6 mr-2" alt="">
                                    <p class="text-red-700">excluir</p>
                                </div>
                            </form>
                        </div>
                    @endif
                @endif
            </div>

            <div class="bg-white p-6 ml-6 flex-1 rounded-lg flex justify-between">
                {{-- Lista de Trâmites --}}
                <div class="flex-1 border bg-gray-200 rounded mr-4">
                    @foreach ($demanda->Tramites->sortBy('id') as $tramite)
                        <div class="flex w-full flex-col rounded bg-white border-b border-gray-300">
                            <div class="flex justify-between p-2 px-4 border-b border-gray-300">
                                <div class="flex">
                                    @if ($tramite->UserTramitou->id == $tramite->UserTramitado->id)
                                        <img src="{{asset('img'.DIRECTORY_SEPARATOR.'notes.svg')}}" class="size-6 mr-2" alt="">
                                        <p>{{$tramite->UserTramitou->name}}</p>
                                    @else
                                        <img src="{{asset('img'.DIRECTORY_SEPARATOR.'user.svg')}}" class="size-6 mr-2" alt="">
                                        <p>{{$tramite->UserTramitou->name}}</p>
                                        <img src="{{asset('img'.DIRECTORY_SEPARATOR.'arrow-right.svg')}}" class="size-6 mx-1" alt="">
                                        <p>{{$tramite->userTramitado->name}}</p>
                                    @endif
                                </div>

                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'small-arrow-down.svg')}}" class="size-6 mr-4  cursor-pointer transition-all" onclick="openTab({{$tramite->id}}, this)">
                            </div>
                            
                            <div class="hidden" id="tab_{{$tramite->id}}">
                                <div class="flex pt-2 px-4 justify-between">
                                    <div class="flex">
                                        <img src="{{asset('img'.DIRECTORY_SEPARATOR.'calendar.svg')}}" class="size-6 mr-2" alt="">
                                        <p class="underline">{{date('d/m/Y H:i', strToTime($tramite->data_tramite))}}</p>
                                    </div>       

                                    @if ((Auth::id() == $tramite->user_id_tramitou || Auth::id() == $tramite->user_id_tramitado) && $demanda->situacao == 0)
                                        <form method="POST" action="{{route('tramites.destroy', $tramite->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <div onclick="ModalDelete(this)" class="cursor-pointer flex">
                                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'trash.svg')}}" class="size-6 opacity-50" alt="">
                                            </div>
                                        </form>
                                    @endif
                                </div>

                                
                                <div class="w-full">
                                    <p class="m-4 my-1 mb-2 p-2 rounded whitespace-normal text-wrap break-words bg-gray-300">{{$tramite->complemento}}</p>
                                </div>

                                <div class="flex justify-between items-center mb-2">
                                    <div class="flex p-2 px-4 max-w-80 ">
                                        @if ($tramite->anexo != null)
                                            <img src="{{asset('img'.DIRECTORY_SEPARATOR.'clip.svg')}}" class="size-6 mr-2" alt="">
                                            <a class="underline" target="_blank" href="{{asset('anexos/'.$tramite->anexo)}}">{{$tramite->anexo}}</a>
                                        @endif
                                    </div>

                                    @if ((Auth::id() == $tramite->user_id_tramitou || Auth::id() == $tramite->user_id_tramitado) && $demanda->situacao == 0)
                                        <div class="flex mr-4">
                                            <a href="{{route('tramites.edit', $tramite->id)}}">
                                                <div class="border p-1 rounded border-black cursor-pointer flex hover:bg-gray-200">
                                                    <img src="{{asset('img'.DIRECTORY_SEPARATOR.'edit.svg')}}" class="size-6 mr-1" alt="">
                                                    <p>Editar</p>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Sidebar de detalhes da demanda --}}
                <div class="flex flex-col">
                    <div>
                        <p class="font-bold mb-1">Informações Gerais</p>
                        <div class="flex">
                            <div class="flex flex-1 p-2 border mr-2 border-gray-300 mb-2 rounded" title="Título">
                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'demanda.svg')}}" class="size-6 mr-1" alt="">
                                <p>{{$demanda->titulo}}</p>
                            </div>
                            <div class="flex p-2 border border-gray-300 mb-2 rounded" title="ID">
                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'lock.svg')}}" class="size-6 mr-1" alt="">
                                <p>{{$demanda->id}}</p>
                            </div>
                        </div>

                        <div class="flex p-2 border border-gray-300 mb-2 rounded"  title="Cliente">
                            <img src="{{asset('img'.DIRECTORY_SEPARATOR.'client.svg')}}" class="size-6 mr-1">
                            <p>{{$demanda->Cliente->nome}}</p>
                        </div>

                        <p class="font-bold mb-1">Ultimo Trâmite</p>
                        <div>
                            <div class="flex p-2 border border-gray-300 mb-2 rounded" title="Usuário Atual">
                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'user.svg')}}" class="size-6 mr-1" alt="">
                                <p>{{$demanda->userAtual->name}}</p>
                            </div>
                            <div class="flex p-2 border border-gray-300 mb-2 rounded" title="Data/Hora do Último Trâmite">
                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'calendar.svg')}}" class="size-6 mr-1" alt="">
                                <p>{{date('d/m/Y H:i', strToTime($demanda->Tramites->last()->data_tramite))}}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="font-bold mb-1">Abertura</p>
                        <div> 
                            <div class="flex p-2 border border-gray-300 mb-2 rounded" title="Usuário de Abertura">
                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'user.svg')}}" class="size-6 mr-1" alt="">
                                <p>{{$demanda->userAbertura->name}}</p>
                            </div>
                            <div class="flex p-2 border border-gray-300 mb-2 rounded" title="Data/Hora de Abertura">
                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'calendar.svg')}}" class="size-6 mr-1" alt="">
                                <p>{{date('d/m/Y H:i', strToTime($demanda->data_abertura))}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTab(id, button){


            if (button.className.includes('open')){
                button.style = 'transform: 0';
                button.className = 'size-6 mr-4 cursor-pointer transition-all';
                document.getElementById('tab_'+id).style.display = 'none';
            } 
            else{
                button.style = 'transform: rotate(180deg)';
                button.className += ' open';
                document.getElementById('tab_'+id).style.display = 'block';
            }
        }
    </script>

    <x-confirmacao-exclusao/>

</x-app-layout>