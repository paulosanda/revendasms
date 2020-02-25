<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\Empresa;

class EmpresaAlt
{
    /**
     * Classe para alterações na tabela empresas
     */
    public function empresaalt($request)
    {
        if(isset($request->arquivo)){
            // apagando arquivo logo se novo for carregado
            $patch = $request->file('arquivo')->store('logos','public');
            // gravando novo logo
            $patch = $request->file('arquivo')->store('logos','public');
        }
        $edit = Empresa::where('id',$request->id)->update([
            'nome'      =>  $request->name,
            'cnae'      =>  $request->cnae,
            'endereco'  =>  $request->endereco,
            'cidade'    =>  $request->cidade,
            'uf'        =>  $request->uf,
            'documento' =>  $request->documento
            
        ]);        
        if(isset($patch)){
            $edit = Empresa::where('id',$request->id)->update(['logo'=> $patch]);
        } 
    }
}
