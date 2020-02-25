<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\Empresa;
use App\Http\Middleware\Psmid\MasterDisparoAlt;
use App\Disparo;

class DisparosOp
{
  /**
   * Adiciona disparos(envios) para uma empresa e diminui saldo geral da revenda
   */
  public function alteradisparos($empresa_id, $recarga, $novo_saldo_disparo)
  {
      $this->empresa_id = $empresa_id;
      $this->recarga = $recarga;
      $this->novo_saldo_disparo = $novo_saldo_disparo;
    
    //recuperando revenda_id na tabela empresas
    $revenda = Empresa::select('revenda_id')->where('id', $empresa_id)->first();
    $revenda_id = $revenda->revenda_id;

    //alterando em master_disparos antes e verificando se há saldo para operação
    $masteraltera = new MasterDisparoAlt;
    $masteraltera->masterdisparooperacao($revenda_id, $recarga);
    
    //fazendo recarga
      $conta = Disparo::where('empresa_id',$empresa_id)->update([
        'saldo'  => $novo_saldo_disparo
    ]);
   
  }

}
