<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\SmsRelatorio;

class RegSmsRelatorio
{
   private $empresa_id;
   private $mensagem;
   private $nummemo;

   public function getRelatorioId($empresa_id, $mensagem)
   {
        $this->empresa_id = $empresa_id;
        $this->mensagem = $mensagem;
        //cria entrada na tabela sms_relatorios e recupera id
        $relatorio = new SmsRelatorio();
        $relatorio->empresa_id = $empresa_id;
        $relatorio->mensagem = $mensagem;
        $relatorio->save();
        $relatorio_id = $relatorio->id; 
        return $relatorio_id;
   }

   public function setNummemo($relatorio_id, $nummemo)
   {
       $this->nummemo = $nummemo;
       info('envios '.$nummemo);
       $this->relatorio_id = $relatorio_id;
       info('relatorio id '. $relatorio_id);
       if($nummemo > 0){
        $setnummemo = SmsRelatorio::find($relatorio_id);
        $setnummemo->total = $nummemo;
        $setnummemo->save();
       }
       
        
       
   }
}
