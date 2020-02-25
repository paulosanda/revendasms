<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\Empresa;
use App\Disparo;
use Illuminate\Http\Request;
use App\Estado;
use App\Cidade;
use App\Revenda;

class CadEmpresa
{
    public function cadempresa($request,$revenda_id){
       
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
        if($revenda_id > 0)
        {
            $emp->revenda_id    = $revenda_id;
        }
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
        // se for cadastro de revenda
        if($revenda_id == 0){
            //inserindo a empresa na tabela revendas pois se for zero é porque não existe revenda acima dela
            $nova_revenda = new Revenda();
            $nova_revenda->empresa_id = $insertedId;
            $nova_revenda->save();
            $revenda_id = $nova_revenda->id;
        }
        //criando entrada na tabela disparos
        $conta = new Disparo();
        $conta->empresa_id = $insertedId;
        $conta->revenda_id = $revenda_id;
        $conta->saldo = 0;
        $conta->save();
        return $insertedId;
    }
}
