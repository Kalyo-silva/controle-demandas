<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
            'nome',
            'cpfcnpj',
            'endereco',
            'email',
            'telefone_contato'
    ];

    function Demandas(){
        return $this->hasMany(Demandas::class);
    }

}
