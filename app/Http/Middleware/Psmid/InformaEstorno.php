<?php
/**
 * Envia SMS aos usuário da empresa que o estorno foi realizado
 */

namespace App\Http\Middleware\Psmid;
use App\User;
use App\Http\Middleware\Psmid\Sms;
use App\MasterDisparo;




class InformaEstorno
{
    private $empresa_id;
    private $smsdados;

    public function setEmpresaId($empresa_id)
    {
        $this->empresa_id = $empresa_id;
    }
    
    public function informaestorno($empresa_id, $erros)
    {
        $this->empresa_id = $empresa_id;
        $this->erros = $erros;
        $mensagem = " a auditoria de erros foi finalizada e $erros envios lhe foram restituidos
        . SEO ADM - sua linha direta com seus clientes!";
        $mensagem = str_replace("\n", ' ', $mensagem);
        $mensagem = str_replace("\r", ' ', $mensagem);
        $user = User::where('empresa_id',$empresa_id)->get();
        $smsdados = new Sms;
        $smsdados = $smsdados->getsms();
        $endpoint = $smsdados['endpoint'];
        $tipo = $smsdados['tipo'];
        $usuario = $smsdados['usuario'];
        $senha = $smsdados['senha'];
        foreach($user as $u)
        {
            if($u->status ==1 && $u->telefone == TRUE)
            {
                $telefone = $u->telefone;
                $telefone = str_replace('(','',$telefone);
                $telefone = str_replace(')','',$telefone);
                $telefone = str_replace('-','',$telefone);
                $telefone = str_replace('.','',$telefone);
                $telefone = str_replace(' ','',$telefone);
                $nome = explode(' ',$u->name);
                $nome = $nome[0];
                $nome = urlencode($nome.' ');
                $memo = urlencode($mensagem);
                $memo = $nome.$memo;
                $url = $endpoint . "t=" . $tipo . "&u=" . $usuario . 
                "&p=". $senha ."&n=" . $telefone . "&m=". $memo . "&i=". 0;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "$url");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec ($ch);
                $err = curl_error($ch);  
                curl_close ($ch);

                //retirando 1 disparo de master_disparos
                MasterDisparo::where('id',1)->decrement('saldo_geral', 1);
            }
        }


    }
    
}
