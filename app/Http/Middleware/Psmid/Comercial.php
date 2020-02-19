<?php

namespace App\Http\Middleware\Psmid;

use Closure;

class Comercial
{
    //Contatos comerciais
    private $comercial =[
        'paulosanda@seo.adm.br',
        'peter@seo.adm.br'
    ];
    public function getComercial(){
        $comercial = $this->comercial;
        return $comercial;
    }
}
