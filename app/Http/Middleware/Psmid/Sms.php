<?php

namespace App\Http\Middleware\Psmid;
//use Closure;

class Sms
{
   /* private $endpoint;
    private $tipo;
    private $usuario;
    private $senha;*/
 
    public function getsms()
    {
        $endpoint = "http://mex10.com/api/shortcode.aspx?";
        $tipo = "send";
        $usuario = "seu-usuario";
        $senha = urlencode("seusenha");


        $smsdados = [
            'endpoint'  => $endpoint,
            'tipo'      => $tipo,
            'usuario'   => $usuario,
            'senha'     => $senha
        ];
        return $smsdados;

    }
}


