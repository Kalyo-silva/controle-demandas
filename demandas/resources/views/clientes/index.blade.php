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
                            <img src="{{asset('img'.DIRECTORY_SEPARATOR.'client.svg')}}" class="size-8 mr-2 cursor-pointer" alt="">
                            <h1 class="text-xl font-bold">Clientes</h1>
                        </div>
                        
                        <div class="flex">
                            <a href="{{route('clientes.create')}}"
                               class="bg-blue-700 hover:bg-blue-900 px-4 py-2 rounded text-white">
                               Novo
                            </a>
                            
                            <form class="flex items-center border border-gray-700 rounded ml-4 focus:border-blue-400"
                                  action="{{route('clientes.search')}}">
                                <button type="submit">
                                    <img src="{{asset('img'.DIRECTORY_SEPARATOR.'search.svg')}}" class="size-6 ml-2 cursor-pointer" alt="Search">
                                </button>
                                <input value="{{$searchString}}" id='Search' class="rounded py-1 border-white focus:border-white focus:ring-0" type="text" name="search">

                                @if ($searchString != '')
                                    <a href="{{url('clientes')}}">
                                        <img src="{{asset('img'.DIRECTORY_SEPARATOR.'clear.svg')}}" 
                                             class="size-6 mr-2 cursor-pointer opacity-50" alt="Search">
                                    </a>
                                @endif
                            </form>
                            
                        </div>
                    </div>
                </div>

                <div class="flex mb-5">
                    
                    @if (!$listaClientes->isEmpty())
                        <table class="border border-collapse w-full table-auto mx-5 rounded">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="border">Nome</th>
                                    <th class="border">CPF / CNPJ</th>
                                    <th class="border">Endereço</th>
                                    <th class="border">Email</th>
                                    <th class="border">Telefone de Contato</th>
                                    <th class="border">Ações</th>
                                </tr>
                            </thead>
                            
                            <tbody>

                                @foreach ($listaClientes as $cliente)
                                    <tr class="text-center">
                                        <td class="border">{{$cliente->nome}}</td>
                                        <td class="border">{{$cliente->cpfcnpj}}</td>
                                        <td class="border">{{$cliente->endereco}}</td>
                                        <td class="border">{{$cliente->email}}</td>
                                        <td class="border">{{$cliente->telefone_contato}}</td>
                                        <td class="border">
                                            <div class="flex justify-center ">
                                                <a href="{{route('clientes.edit', $cliente->id)}}">
                                                    <img class="size-6 cursor-pointer" src="{{asset('img'.DIRECTORY_SEPARATOR.'edit.svg')}}" alt="Editar">
                                                </a>

                                                <form method="POST" action="{{route('clientes.destroy', $cliente->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="ModalDelete(this)">
                                                        <img class="size-6 cursor-pointer" src="{{asset('img'.DIRECTORY_SEPARATOR.'trash.svg')}}" alt="Excluir">
                                                    </button>    
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="p-6 w-full text-center">Nenhum Registro Encontrado...</p>
                    @endif
                </div>
                
                <div class="mb-5 mx-5">
                    {{$listaClientes->links()}}
                </div>
            </div>
        </div>
    </div>
    
    <x-confirmacao-exclusao/>

</x-app-layout>
