<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\Revenda;
use App\Empresa;

class Revendaid
{
    /**
     * Carrega o id da revenda atraves do empresa_id 
     */
    public function revendaid($empresa_id)
    {
        $id = Revenda::where('empresa_id', $empresa_id)->first();
        //dd($id);
        return $id->id;
    }
    
}
