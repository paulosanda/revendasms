<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Middleware\Psmid\Comercial;
use Illuminate\Http\Request;
use App\Empresa;

class NovaConta extends Mailable
{
    use Queueable, SerializesModels;
 
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $this->request = $request;
        $usuario = $request->name;
        $telefone = $request->telefone;
        $email = $request->email;
        $empresa_id = $request->empresa_id;
        $empresa_nome = Empresa::select('nome')->where('id',$empresa_id)->first();
        $comercial = new Comercial;
        $comercial = $comercial->getComercial();

        return $this->from([
            'address' => 'suporte@seo.adm.br',
            'name'    => 'Cadastro de nova conta'
            ])
            ->to($comercial)
        ->subject('SEO ADM - Nova conta')
        ->view('mail.novaconta')
        ->with([    
            'Usuario' => $usuario,
            'Email' => $email,
            'Telefone' => $telefone,
            'Empresa' =>$empresa_nome]);
    }
}
