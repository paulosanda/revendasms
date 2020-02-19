<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\SmsLogErro;

/**
 * O objetivo desta classe é verificar se o telefone consta na tabela sms_log_erros
 * Esta classe foi inicialmente criada para ser usada no sistema de auditoria de erros 
 * ao receber o retorno do fornecedor de envios
 * retorna True se o número existir na tabela
 */

class CheckLogErros
{
   //private $numero;
   //private $repetido;

   public function getRepetido($empresa_id, $numero)
   {
        $this->empresa_id = $empresa_id;
        $this->numero = $numero;
        $repetido = SmsLogErro::where([
            'telefone'      =>$numero,
            'empresa_id'    =>$empresa_id
            ])
        ->count();
       return $repetido;
   }

}
