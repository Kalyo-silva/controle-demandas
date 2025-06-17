<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center border-b pb-2 border-gray-900/10">
                        <div class='flex items-center'>
                            <img src="{{asset('img'.DIRECTORY_SEPARATOR.'client.svg')}}" class="size-8 mr-2 cursor-pointer" alt="">
                                
                            @if ($mode == 'create')
                                <h1 class="text-xl font-bold">Novo Cliente</h1>
                            @else
                                <h1 class="text-xl font-bold">Editar Cliente</h1>
                            @endif
                        </div>
                    </div>
                    
                    @if ($mode == 'create')
                        <form class="mt-5" action="{{route('clientes.store')}}" method="POST">
                        
                    @else
                        <form class="mt-5" action="{{route('clientes.update', $cliente->id)}}" method="POST">
                        @method('PUT')
                    @endif
                        
                        @csrf

                        <div class="flex justify-between">
                            <div class="flex flex-col mb-2 mr-4 w-full">
                                <label for="nome">Nome</label>
                                <input placeholder="Nome do Cliente..." 
                                       class="rounded border-gray-900/30" 
                                       type="text"
                                       name="nome" 
                                       id="nome"
                                       @if ($mode == 'edit')
                                           value="{{$cliente->nome}}"
                                       @endif                                       
                                >
                            </div>
                            
                            <div class="flex flex-col mb-2 w-80">
                                <label for="cpfcnpj">CPF/CNPJ</label>
                                <input placeholder="000.000.000-00" 
                                       class="rounded border-gray-900/30" 
                                       type="text" 
                                       name="cpfcnpj" 
                                       id="cpfcnpj"
                                       @if ($mode == 'edit')
                                           value="{{$cliente->cpfcnpj}}"
                                       @endif
                                >
                            </div>
                        </div>
                        
                        <div class="flex flex-col mb-2">
                            <label for="endereco">Endereço</label>
                            <input placeholder="Rua X, Nº 000, Bairro, Cidade - UF" 
                                   class="rounded border-gray-900/30" 
                                   type="text" 
                                   name="endereco" 
                                   id="endereco"
                                    @if ($mode == 'edit')
                                        value="{{$cliente->endereco}}"
                                    @endif
                            >
                        </div>
                        
                        <div class="flex justify-between">
                            <div class="flex flex-col mb-2 w-full mr-2">
                                <label for="email">Email</label>
                                <input placeholder="exemplo@email.com" 
                                       class="rounded border-gray-900/30" 
                                       type="email" 
                                       name="email" 
                                       id="email"
                                       @if ($mode == 'edit')
                                           value="{{$cliente->email}}"
                                       @endif                        
                                >
                            </div>
                            
                            <div class="flex flex-col mb-2 w-full ml-2">
                                <label for="telefone_contato">Telefone de Contato</label>
                                <input placeholder="+00 (00) 00000-0000" 
                                       class="rounded border-gray-900/30" 
                                       type="text" 
                                       name="telefone_contato" 
                                       id="telefone_contato"
                                       @if ($mode == 'edit')
                                           value="{{$cliente->telefone_contato}}"
                                       @endif                 
                                >
                            </div>
                        </div>
                        <div class="flex justify-end mt-2">
                            <a href="{{route('clientes.index')}}" class="px-4 py-2 text-red-700 ring-1 ring-red-700 hover:bg-red-900 rounded hover:text-white">Cancelar</a>
                            <button class="px-4 py-2 text-green-700 ring-1 ring-green-700 hover:bg-green-900 rounded hover:text-white ml-2" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
