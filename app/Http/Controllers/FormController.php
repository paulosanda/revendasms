<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContatoForm;
use App\Rules\GoogleRecaptcha;

class FormController extends Controller
{
    // @param  \Illuminate\Http\Request  $request
    // @return \Illuminate\Http\Response
    public function enviar(Request  $request){
        $regras = [
            'nome'   => 'required',
            'email'     => 'required',
            'celular'     => 'required',
            'g-recaptcha-response' => 'required'
        ];
        $mensagens = [
            'nome.required' => 'Por favor nos diga seu nome',
            'email.required' => 'Acho que você esqueceu de inserir seu e-mail',
            'celular.required' => 'Ops! Por favor informe seu celular',
            'g-recaptcha-response.required' => "Você é um robô?"
        ];

        $request->validate($regras, $mensagens);

        Mail::send(new ContatoForm());

        session()->flash('success', 'Agradecemos sua mensagem, em breve entraremos em contato.');
 
        return redirect()->back();
    }
}
