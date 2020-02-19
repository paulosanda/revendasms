<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteGrupo extends Model
{
    public function GrupoCliente(){
        return $this->hasMany('App\Cliente');
    }

    public function grupoclientes(){
        return $this->belongsTo('App\Cliente','cliente_id','id');
    }

}
