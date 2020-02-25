<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\MasterDisparo;

class MasterDisparoAlt
{
    public function masterdisparoaltera($request)
    {
        $altera = MasterDisparo::where('revenda_id',$request->revenda_id)
        ->update(['saldo_geral' => $request->saldo_geral_novo]);
        return $altera;
    }

    /**
     * a função abaixo é para realizar alteraçao na tabela master disparo 
     * a partir de soma ou subtração do saldo e recarga
     * Controller que estão usando:
     * AdminDisparoController
     */
    public function masterdisparooperacao($revenda_id,$recarga)
    {
        //carrega saldo atual
        $saldo = MasterDisparo::where('revenda_id', $revenda_id)->first();
        $saldo = $saldo->saldo_geral;
        //se recarga for valor positivo
        $recarga = intval($recarga);
        
        
            $novo_saldo = $saldo - $recarga;
            //echo 'saldo menos';
            //dd($novo_saldo);
        
        if($novo_saldo < 0 )
        {
            echo "ERRO! Seu saldo não é suficiente para realizar esta operação!";
            exit;
        } else {
            MasterDisparo::where('revenda_id', $revenda_id)
            ->update(['saldo_geral' => $novo_saldo]);
        }

    }
}
