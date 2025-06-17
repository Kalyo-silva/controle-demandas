<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\demanda_tramites;
use App\Models\Demanda;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DemandaTramitesController extends Controller
{
    public function store(Request $request){
        try {
            $demanda = Demanda::find($request->input('demanda_id'));

            $demanda->user_id_atual = $request->input('user_id_atual');

            $tramite = new demanda_tramites();

            $tramite->complemento = $request->input('complemento');
            $tramite->demanda_id = $request->input('demanda_id');
            $tramite->user_id_tramitou = Auth::id();
            $tramite->user_id_tramitado = $request->input('user_id_atual');
            if ($anexo = $request->file('anexo')) {
                $filename = date('YmdHis').$anexo->getClientOriginalName();
                $anexo->move(public_path('anexos'),$filename);
                $tramite->anexo = $filename;
            }    
            
            if ($tramite->save()){
                $demanda->save();
                return redirect()->route('demandas.show', $tramite->demanda_id)->with('success', 'Complemento adicionado com sucesso!');
            }         
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, int $id){
        try {
            $tramite = demanda_tramites::findOrFail($id);

            $tramite->complemento = $request->input('complemento');
            if ($anexo = $request->file('anexo')) {
                $filename = date('YmdHis').$anexo->getClientOriginalName();
                $anexo->move(public_path('anexos'),$filename);
                $tramite->anexo = $filename;
            }    
            
            if ($tramite->save()){
                return redirect()->route('demandas.show', $tramite->demanda_id)->with('success', 'Complemento adicionado com sucesso!');
            }         

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function complemento(int $id_demanda){
        try {
            $demanda = Demanda::find($id_demanda);

            return view('tramites.complemento', compact('demanda'));
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function edit(int $id){
        try {
            $tramite = demanda_tramites::findOrFail($id);
            $demanda = Demanda::findOrFail($tramite->demanda_id);

            return view('tramites.edit', compact('tramite', 'demanda'));
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function tramitar(int $id_demanda){
        try {
            $demanda = Demanda::find($id_demanda);
            $listaUsers = User::all();

            return view('tramites.tramitar', compact('demanda', 'listaUsers'));
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function destroy(int $id){
        $tramite = demanda_tramites::findOrFail($id);

        $demanda = Demanda::findOrFail($tramite->demanda_id);
    
        $tramite->delete();

        $demanda->user_id_atual = $demanda->Tramites->last()->user_id_tramitado;

        if ($demanda->save()){
            return redirect()->route('demandas.show', $demanda->id)->with('success', 'Complemento removido com sucesso!');;
        }
    }
}
