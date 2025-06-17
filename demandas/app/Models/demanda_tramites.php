<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class demanda_tramites extends Model
{

    protected $fillable = [
        'id',
        'demanda_id',
        'complemento',
        'anexo',
        'user_id_tramitou',
        'user_id_tramitado'
    ];

    const CREATED_AT = 'data_tramite';
    const UPDATED_AT = 'data_atualizado';

    function Demanda(){
        return $this->belongsTo(Demanda::class);
    }


    function UserTramitou(){
        return $this->belongsTo(User::class, 'user_id_tramitou');
    }

    function userTramitado(){
        return $this->belongsTo(User::class, 'user_id_tramitado');
    }
}
