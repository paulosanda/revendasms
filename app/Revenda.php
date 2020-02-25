<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revenda extends Model
{
    public function listEmpresa(){
        return $this->hasMany('App\Empresa');
    }
    public function revendadados(){
        return $this->hasOne('App\Empresa','id','empresa_id');
    }
    public function revendauser(){
        return $this->hasmany('App\User,empresa_id','empresa_id');
    }
    public function masterdisparos(){
        return $this->hasOne('App\MasterDisparo');
    }
}
