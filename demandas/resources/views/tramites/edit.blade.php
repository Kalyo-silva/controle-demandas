<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center pb-2 border-b border-gray-300">
                        <img src="{{asset('img'.DIRECTORY_SEPARATOR.'notes.svg')}}" class='size-8 mr-2'>
                        <h1 class="text-xl font-bold">Editar Complemento</h1>
                    </div>
                    
                    <div class="flex">
                        <div class="flex flex-col justify-between w-fit mt-4">
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
                            </div>

                            <div>
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
                    
                        <form class="flex flex-col flex-1" enctype="multipart/form-data" action="{{route('tramites.update', $tramite->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                            <input type="hidden" value="{{$demanda->Tramites->last()->userTramitado->id}}" name="user_id_atual">
                            <input type="hidden" value="{{$demanda->id}}" name="demanda_id">

                            <div class="flex flex-col flex-1 ml-4 mt-4 mb-2">
                                <p class="font-bold mb-1">Complemento</p>
                                <textarea name="complemento" 
                                        id="complemento" 
                                        class="rounded flex-1 h-full w-full border-gray-300 mb-2">{{$tramite->complemento}}</textarea>

                                <div class="flex justify-between">
                                    <div class="flex flex-col">
                                        <div class= "rounded flex">
                                            <div class="flex cursor-pointer bg-blue-700 w-fit px-4 py-2 rounded">
                                                <img src="{{asset('img'.DIRECTORY_SEPARATOR.'clip-white.svg')}}" class="size-6 mr-1">
                                                <label for="anexo" 
                                                class=" text-white cursor-pointer">Anexar Arquivo
                                                </label>
                                            </div>
                                            <input type="file" 
                                                name="anexo" 
                                                id="anexo"
                                                class="opacity-0 w-0">
                                            <div id="Preview" class="flex overflow-hidden">
                                                @if($tramite->anexo != null)
                                                    <div class="rounded border h-full border-gray-300 flex items-center w-fit ml-4 overflow-hidden">
                                                        @if(in_array(pathinfo($tramite->anexo, PATHINFO_EXTENSION),  ['jpg', 'jpeg', 'png', 'svg']))
                                                            <img src="{{asset('anexos'.DIRECTORY_SEPARATOR.$tramite->anexo)}}" class=" w-10 h-full bg-gray-300 mr-2">
                                                        @else
                                                            <div class="w-10 h-full bg-gray-300 mr-2"></div>
                                                        @endif

                                                        <p class="mr-2">{{$tramite->anexo}}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-end">
                                        <a href="{{route('demandas.show', $demanda->id)}}" class="px-4 py-2 text-red-700 ring-1 ring-red-700 hover:bg-red-900 rounded hover:text-white">Cancelar</a>
                                        <button class="px-4 py-2 text-green-700 ring-1 ring-green-700 hover:bg-green-900 rounded hover:text-white ml-2" type="submit">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        const input = document.getElementById("anexo");
        const Preview = document.getElementById("Preview");

        input.addEventListener("change", updateImageDisplay);

        function updateImageDisplay(){        
            const curFiles = input.files;

            if (curFiles.length != 0){ 
                while (Preview.firstChild){
                    Preview.removeChild(Preview.firstChild);
                }

                for (const file of curFiles) {
                    const anex = document.createElement("div");
                    anex.className = "rounded border h-full border-gray-300 flex items-center w-fit ml-4 overflow-hidden";
                    
                    console.log((file.name).split('.').pop());

                    let imgExtensions = ['jpg', 'jpeg', 'png', 'svg'];
                    if (imgExtensions.includes((file.name).split('.').pop())){
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file)
                        img.className = "w-10 h-full bg-gray-300 mr-2";

                        anex.appendChild(img);
                    }
                    else{
                        const icon = document.createElement("div");
                        icon.className = "w-10 h-full bg-gray-300 mr-2";

                        anex.appendChild(icon);
                    }

                    const tag = document.createElement('p');
                    
                    tag.className = "mr-2";
                    tag.innerText = file.name;
                    
                    anex.appendChild(tag);
                    Preview.appendChild(anex);
                }
            }
        }
    </script>

</x-app-layout>