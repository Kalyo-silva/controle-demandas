<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index(){
        $listaClientes = Cliente::orderBy('nome', 'asc')->paginate(15);

        $searchString = '';

        return view('clientes.index', compact('listaClientes', 'searchString'));
    }

    public function create(){
        $mode = 'create';

        return view('clientes.create' ,compact('mode'));
    }

    public function search(Request $request){
        $searchString = $request->input('search');
        
        $listaClientes = Cliente::where('nome', 'ilike', '%'.$searchString.'%')->orderBy('nome', 'asc')->paginate(15);

        // return json_encode($listaClientes);

        return view('clientes.index', compact('listaClientes', 'searchString'));
    }

    public function edit(int $id){
        $mode = 'edit';

        $cliente = Cliente::findOrFail($id);

        return view('clientes.create', compact('mode', 'cliente'));
    }

    public function store(Request $request){
        $cliente = new Cliente();

        $cliente->nome = $request->input('nome');
        $cliente->cpfcnpj = $request->input('cpfcnpj');
        $cliente->endereco = $request->input('endereco');
        $cliente->email = $request->input('email');
        $cliente->telefone_contato = $request->input('telefone_contato');

        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');;
    }

    public function update(Request $request, int $id){
        $cliente = Cliente::findOrFail($id);

        $cliente->nome = $request->input('nome');
        $cliente->cpfcnpj = $request->input('cpfcnpj');
        $cliente->endereco = $request->input('endereco');
        $cliente->email = $request->input('email');
        $cliente->telefone_contato = $request->input('telefone_contato');

        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente alterado com sucesso!');
    }

    public function destroy(int $id){
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        
        return redirect()->route('clientes.index')->with('success', 'Cliente removido com sucesso!');
    }
}
