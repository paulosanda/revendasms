<?php
/**
 * Para deletar "contatos" melhor dizer clientes é preciso observar as tabelas
 * que tem o id do cliente como FK
 * TABLELAS  ATÉ 10/02/2020
 * cliente - id
 * cliente_grupos - cliente_id
 * 
 */
namespace App\Http\Middleware\Psmid;
use App\Cliente;
use App\ClienteGrupo;

class DeletaContato
{
   private $empresa_id;

   //Deletando todos em tabelas cliente e cliente_grupos
    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = $empresa_id;
    }
    public function deletacontatoall() 
    {
        $empresa_id = $this->empresa_id;
        //primeiro apagar em cliente_grupos
        ClienteGrupo::where('empresa_id',$empresa_id)->delete();
        //apagar em clientes
        Cliente::where('empresa_id',$empresa_id)->delete();
    }
    
}
