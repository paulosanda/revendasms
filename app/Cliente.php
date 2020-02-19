<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function ClienteGrupo(){
        return $this->belongsToMany('App\GrupoContato','cliente_grupos');
    }
}
