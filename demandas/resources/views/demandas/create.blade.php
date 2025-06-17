<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center border-b pb-2 border-gray-900/10">
                        <div class='flex items-center'>
                            <img src="{{asset('img'.DIRECTORY_SEPARATOR.'demanda-add.svg')}}" class="size-8 mr-2 cursor-pointer" alt="">
                            <h1 class="text-xl font-bold">Nova Demanda</h1>
                        </div>
                    </div>
                    
                    <form class="mt-5" enctype="multipart/form-data" action="{{route('demandas.store')}}" method="POST">
                        @csrf
                        <div class="flex">
                            <div class="flex flex-col mb-4 w-full">
                                <label for="titulo">Titulo</label>
                                <input placeholder="Titulo da Demanda..." 
                                    class="rounded border-gray-300" 
                                    type="text"
                                    name="titulo" 
                                    id="titulo"              
                                >
                            </div>
                            
                            <div class="flex flex-col ml-4">
                                <label for="datetime-local">Data Abertura</label>
                                <input class="rounded border-gray-300"
                                        type="date"
                                        value="{{$data}}"
                                        readonly>
                            </div>
                        </div>
                        
                        <div class="flex">
                            <div class="flex flex-col mb-4 mr-4 w-full">
                                <label for="user_id_atual">Usuário Responsável</label>
                                <select name="user_id_atual" id="user_id_atual" class="select2">
                                    <option value="0">Selecione...</option>
                                    @foreach ($listaUsers as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>                                            
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col w-full">
                                <label for="cliente_id">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="select2">
                                    <option value="0">Selecione...</option>
                                    @foreach ($listaClientes as $cliente)
                                        <option value="{{$cliente->id}}">{{$cliente->nome}}</option>                                            
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex flex-col mb-4">
                            <label for="complemento">Descrição da Abertura</label>
                            <textarea class="rounded border-gray-300"
                                        name="complemento" 
                                        id="complemento" 
                                        cols="30" 
                                        rows="10"></textarea>
                        </div>

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
                                    
                                </div>
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


    <!-- Inclusão das bibliotecas Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Selecione",
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    
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