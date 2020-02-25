<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\Empresa;

class EmpresaSelect
{
   /**
    * seleciona empresa por id na tabela empresas e também users da empresa
    */
    public function empSelect($id)
    {
        $empresadados = Empresa::with('listUser')->where('id', $id)->first();
        return $empresadados;
    }
}
