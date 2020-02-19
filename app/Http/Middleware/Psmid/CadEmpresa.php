<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\Empresa;
use App\Disparo;
use Illuminate\Http\Request;
use App\Estado;
use App\Cidade;

class CadEmpresa
{
    public function cadempresa(Request $request){
       
        if(is_numeric($request->estado)) {
            $estado = Estado::find($request->estado);
            $estado = $estado->sigla;
        } else {
            $estado = $request->estado;
        }
        if(is_numeric($request->cidade)) {
            $cidade = Cidade::find($request->cidade);
            $cidade = $cidade->cidade;
        } else {
            $cidade = $request->cidade;
        }
        if(isset($request->arquivo)){
            $patch = $request->file('arquivo')->store('logos','public');
        }
        
        $emp = new Empresa();
        $emp->nome  =  $request->nome;
        $emp->cnae  =  $request->cnae;
        $emp->endereco  =  $request->endereco;
        $emp->cidade  =  $cidade;
        $emp->uf  =  $estado;
        $emp->documento  =  $request->documento;
        if(isset($patch)){
            $emp->logo = $patch;
        }
        $emp->save();
        $insertedId = $emp->id;
        //criando entrada na tabela disparos
        $conta = new Disparo();
        $conta->empresa_id = $insertedId;
        $conta->saldo = 0;
        $conta->save();
        return $insertedId;
    }
}
