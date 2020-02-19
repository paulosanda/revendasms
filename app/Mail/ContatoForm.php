<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class ContatoForm extends Mailable
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
   
    public function build(Request $request){
         
        return $this->from([
                'address' => $request->email, 
                'name' => $request->nome 
            ])
            ->to(['paulosanda@seo.adm.br','peter@seo.adm.br'])
            ->subject( 'Contato SEO: ')
            ->view('mail.formcontato')
            ->with([    
                'Nome' => $request->nome,
                'Celular' => $request->celular,
                'Email' => $request->email
            ]);
 
    }
}
