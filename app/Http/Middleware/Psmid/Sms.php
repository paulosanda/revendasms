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
        $usuario = "paulosanda@seo.adm.br";
        //$this->senha = "&&Ps20Rt25@ai4@!!";
        $senha = urlencode("&&Ps20Rt25@ai4@!!");
        /*
        $endpoint = "http://mex10.com/api/shortcode.aspx?";
        $tipo = "send";
        $usuario="paulosanda@seo.adm.br";
        $senha="&&Ps20Rt25@ai4@!!";
        $senha=urlencode($senha);*/

        $smsdados = [
            'endpoint'  => $endpoint,
            'tipo'      => $tipo,
            'usuario'   => $usuario,
            'senha'     => $senha
        ];
        return $smsdados;

    }
}




$endpoint = "http://mex10.com/api/shortcode.aspx?";
$tipo = "send";
$usuario="paulosanda@seo.adm.br";
$senha="&&Ps20Rt25@ai4@!!";
$senha=urlencode($senha);
