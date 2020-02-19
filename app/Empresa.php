<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    public function listUser(){
        return $this->hasMany('App\User');
    }
    public function disparo(){
        return $this->hasOne('App\Disparo');
    }
    public function GrupoContato(){
        return $this->hasMany('App\GrupoContato');
    }
    public function EmpresaCliente(){
        return $this->hasMany('App\Cliente');
    }
    public function EmpresaSmsErro(){
        return $this->hasMany('App\SmsLogErro');
    }
}
