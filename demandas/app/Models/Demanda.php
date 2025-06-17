<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\demanda_tramites;
use App\Models\Cliente;
use App\Models\User;

class Demanda extends Model
{
    protected $fillable = [
        'cliente_id',
        'user_id',
        'user_id_atual',
        'titulo',
        'situacao'
    ];

    const CREATED_AT = 'data_abertura';
    const UPDATED_AT = 'data_atualizado';

    function Tramites(){
        return $this->hasMany(demanda_tramites::class);
    }

    function Cliente(){
        return $this->belongsTo(Cliente::class);
    }

    function UserAbertura(){
        return $this->belongsTo(User::class, 'user_id');
    }

    function userAtual(){
        return $this->belongsTo(User::class, 'user_id_atual');
    }
}
