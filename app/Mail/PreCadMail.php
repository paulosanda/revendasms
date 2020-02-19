<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class PreCadMail extends Mailable
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
        return $this->from([
            'address' => 'suporte@seo.adm.br',
            'name'    => 'Suporte SEO ADM'
            ])
            ->to([$request->email])
        ->subject('SEO ADM - Seu pré-cadastro foi liberado')
        ->view('mail.precadmail')
        ->with([    
            'Nome' => $request->nome,
            'Email' => $request->email]);
       
    }
}
