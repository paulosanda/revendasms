@extends('layouts.menu')
@section('contenteudo')

 <!-- Header -->

<header class="bg-primary py-5 mb-5" style="background-image:url({{url('/')}}/img/smsmkt.jpg)">
    <div class="container h-100">
      <div class="row h-100 align-items-center" style=" background-color: #006400; 
        posição:absoluta; z-index:-1; top:0; left:0; right:0; bottom:0; opacity:0.9;">
        <div class="col-lg-12">
          <h2 class="display-6 text-white mt-5 mb-2">{{session('nome')}} bem vindo!</h2>
         

        </div>
      </div>
    </div>
  </header>


<!--- Finalizado --->
@if(isset($finalizado))
<div class="container">
  <div class="row">
    <div class="col-md-8 mb-5"> 
      <h2>PARABÉNS!</h2>
      <hr>
      <p>{{$usuario}} sua conta e usuário foram criados com sucesso.</p>
    
      <p>Você já pode fazer o login em sua conta, porém como lhe informamos seu usuário ainda está bloqueado,
        em breve seu consultor entrará em contato, então o usuário será liberado.<br>
      Desculpe-nos o transtorno mas isto é sempre para sua segurança e de sua empresa.</p>    
      <p> Logo mais você estará em contato direto com toda sua base de clientes, ou ainda organiza-los em grupos e enviar 
        mensagens personalizadas para cada grupo!</p>
        <p> Mas não é só isso! <strong>Quer mais clientes?</strong> <br>
        Fale com seu consultor sobre nossas listas de pefis!</p>
    </div>
    <div class="col-md-4 mb-5">
      <img src="{{url('/')}}/img/taxasdeconvercao.png" alt="Mais vendas para você!">
  </div>
</div>
@endif


@endsection
