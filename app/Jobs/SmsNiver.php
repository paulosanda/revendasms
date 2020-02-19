<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Disparo;
use App\Cliente;
use App\SmsLogErro;
use App\SmsRelatorio;
use App\Http\Middleware\Psmid\Sms;
use App\Http\Middleware\Psmid\RegSmsRelatorio;



class SmsNiver implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $empresa_id;
    private $mensagem;
    private $contatos;
    private $relatorio_id;
    public $tries = 100;
    public $timeout = 900;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($empresa_id, $mensagem,$contatos, $relatorio_id)
    {
        $this->empresa_id   = $empresa_id;
        $this->mensagem     = $mensagem;
        $this->contatos     = $contatos;
        $this->relatorio_id = $relatorio_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $empresa_id = $this->empresa_id;
        $mensagem   = $this->mensagem;
        $contatos   = $this->contatos;
        $relatorio_id = $this->relatorio_id;

        //Parametros para o envio de SMS
        $smsdados = new Sms;
        $smsdados = $smsdados->getsms();
        $endpoint = $smsdados['endpoint'];
        $tipo = $smsdados['tipo'];
        $usuario = $smsdados['usuario'];
        $senha = $smsdados['senha'];
        $nummemo =0;
                
        foreach($contatos as $cli){
            $telefone = $cli->telefone;
            $telefone = str_replace('(','',$telefone);
            $telefone = str_replace(')','',$telefone);
            $telefone = str_replace('-','',$telefone);
            $telefone = str_replace('.','',$telefone);
            $telefone = str_replace(' ','',$telefone);
                       
            $nome = explode(' ',$cli->nome);
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
            
            if (preg_match('%NOK%', $response)){
                $logerro = new SmsLogErro();
                $logerro->empresa_id = $empresa_id;
                $logerro->telefone = $telefone;
                $logerro->save(); 

            } 
            else {
                $nummemo ++;
            }
            
            //Fim do envio            
        }
        
        $smsrelatorioupdate = new RegSmsRelatorio;
        $smsrelatorioupdate->setNummemo($relatorio_id, $nummemo); 
    }
}
