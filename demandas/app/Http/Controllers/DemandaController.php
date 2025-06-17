<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda;
use App\Models\Cliente;
use App\Models\User;
use App\Models\demanda_tramites;
use Illuminate\Support\Facades\Auth;


class DemandaController extends Controller
{
    public function index(){
        $listaDemandas = Demanda::where('user_id_atual', Auth::id())
                                ->where('situacao', '0')
                                ->orderBy('data_atualizado', 'desc')
                                ->paginate(9);

        $searchString = '';
        $concluido = false;
        $todos = false;

        return view('demandas.index', compact('listaDemandas', 'searchString', 'concluido', 'todos'));
    }

    public function search(Request $request){
        $searchString = $request->input('search');
        $concluido = $request->has('concluido');
        $todos = $request->has('todos');
        
        if (!$concluido && !$todos){
            $listaDemandas = demanda::where('user_id_atual', Auth::id())
                                    ->where('situacao', 0)
                                    ->where('titulo', 'ilike', '%'.$searchString.'%')
                                    ->orderBy('data_atualizado', 'desc')
                                    ->paginate(9);
        }
        else if (!$concluido){
            $listaDemandas = demanda::where('situacao', 0)
                                    ->where('titulo', 'ilike', '%'.$searchString.'%')
                                    ->orderBy('data_atualizado', 'desc')
                                    ->paginate(9);
        }
        else if (!$todos){
            $listaDemandas = demanda::where('user_id_atual', Auth::id())
                                    ->where('titulo', 'ilike', '%'.$searchString.'%')
                                    ->orderBy('data_atualizado', 'desc')
                                    ->paginate(9);
        }
        else{
            $listaDemandas = demanda::where('titulo', 'ilike', '%'.$searchString.'%')
                                    ->orderBy('data_atualizado', 'desc')
                                    ->paginate(9);
        }

        return view('demandas.index', compact('listaDemandas', 'searchString', 'concluido', 'todos'));
    }

    public function create(){
        $listaUsers = User::all();
        $listaClientes = Cliente::all();
        $data = Date("Y-m-d");

        return view('demandas.create' ,compact('listaUsers', 'listaClientes', 'data'));
    }

    public function edit(int $id){
        $demanda = Demanda::find($id);
        $listaClientes = Cliente::all();

        return view('demandas.edit' ,compact('demanda', 'listaClientes'));   
    }

    public function store(Request $request){
        try {
            $demanda = new Demanda();

            $demanda->cliente_id = $request->input('cliente_id');
            $demanda->user_id = Auth::id();
            $demanda->user_id_atual = $request->input('user_id_atual');
            $demanda->titulo = $request->input('titulo');
            $demanda->situacao = 0;

            if ($demanda->save()){
                $request->request->add(['demanda_id' => $demanda->id]);

                return app('App\Http\Controllers\DemandaTramitesController')->store($request);
            }        
        } catch (\Throwable $th) {
            return $th;
        }      
    }

    public function update(Request $request, int $id){
        $demanda = Demanda::findOrFail($id);

        $demanda->titulo = $request->input('titulo');
        $demanda->cliente_id = $request->input('cliente_id');
        
        $demanda->save();

        return redirect()->route('demandas.show', $id)->with('success', 'Demanda alterada com sucesso!');
    }

    public function concluir(int $id){
        $demanda = Demanda::findOrFail($id);

        if ($demanda->situacao == 1){
            $demanda->situacao = 0;
        } 
        else{
            $demanda->situacao = 1;
        }

        if ($demanda->save()){
            return redirect()->route('demandas.index')->with('success', 'Situação da demanda alterada com sucesso!');
        }
    }

    public function show($id){
        $demanda = Demanda::find($id);

        return view('demandas.show', compact('demanda'));
    }

    public function destroy($id){
        $demanda = Demanda::find($id);

        $tramites = demanda_tramites::where('demanda_id',$id)->get();

        foreach ($tramites as $tramite) {
            $tramite->delete();
        }

        $demanda->delete();

        return redirect()->route('demandas.index')->with('success', 'Demanda removida com sucesso!');
    }
}
