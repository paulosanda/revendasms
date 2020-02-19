<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoContato extends Model
{
    public function cliente(){

        return $this->belongsToMany('App\Cliente', 'cliente_grupos');
        
    }
    public function cliente_grupo(){

        return $this->hasMany('App\ClienteGrupo');
        
    }
}
