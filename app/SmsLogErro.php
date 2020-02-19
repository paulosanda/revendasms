<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsLogErro extends Model
{
    public function SmsErroEmpresa(){
        return $this->belongsTo('App\Empresa','empresa_id');
    }
}
