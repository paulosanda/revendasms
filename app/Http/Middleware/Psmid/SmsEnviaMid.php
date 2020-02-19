<?php

namespace App\Http\Middleware\Psmid;
use App\Http\Middleware\Psmid\Sms;

use Closure;

class SmsEnviaMid
{
   public function smsenviamid($nome, $mensagem,$telefone,$relatorio_id)
   {
        $this->nome = $nome;
        $this->mensagem = $mensagem;
        $this->telefone = $telefone;
        $this->relatorio_id = $relatorio_id;
        $smsdados = new Sms;
        $smsdados = $smsdados->getsms();
        $endpoint = $smsdados['endpoint'];
        $tipo = $smsdados['tipo'];
        $usuario = $smsdados['usuario'];
        $senha = $smsdados['senha'];
        //tratando a var telefone
        $telefone = str_replace('(','',$telefone);
        $telefone = str_replace(')','',$telefone);
        $telefone = str_replace('-','',$telefone);
        $telefone = str_replace('.','',$telefone);
        $telefone = str_replace(' ','',$telefone);
            // iniciando envio
           
        $nome = explode(' ',$nome);
        $nome = $nome[0];
            
        $nome = urlencode($nome.' ');
        $memo = urlencode($mensagem);
        $memo = $nome.$memo;
        $url = $endpoint . "t=" . $tipo . "&u=" . $usuario . 
        "&p=". $senha ."&n=" . $telefone . "&m=". $memo . "&i=" . $relatorio_id;
            
        //início do envio 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec ($ch);
        $err = curl_error($ch);  
        curl_close ($ch);     
        
        if(isset($empresa_id)){
            if (preg_match('%NOK%', $response)){
            $logerro = new SmsLogErro();
            $logerro->empresa_id = $empresa_id;
            $logerro->telefone = $telefone;
            $logerro->save(); 
            }
        }
        
   }
}
