@extends('layouts.menu')
@section('contenteudo')

 <!-- Header -->

<header class="bg-primary py-5 mb-5" style="background-image:url({{url('/')}}/img/smsmkt.jpg)">
    <div class="container h-100">
      <div class="row h-100 align-items-center" style=" background-color: #006400; 
        posição:absoluta; z-index:-1; top:0; left:0; right:0; bottom:0; opacity:0.9;">
        <div class="col-lg-12">
          <h2 class="display-6 text-white mt-5 mb-2">{{session('nome')}} bem vindo!</h2>
          <p class="lead mb-10 text-white-50">Se você acessou esta página é porque já iniciou seu processo de cadstro, por favor no campo abaixo insira seu e-mail<br>
           Se não inicou ainda no menu acima utilize Contato.</p>

        </div>
      </div>
    </div>
  </header>


<!--- Finalizado --->
@if(isset($cancela))
<div class="container">
  <div class="row">
    <div class="col-md-8 mb-5"> 
      <h2>Ouve um engano?</h2>
      <hr>
      <p>{{$precad->nome}} houve um engano?</p>
    
      <p>Se você recebeu o e-mail com o aviso de início de cadastro por engano 
        ou não deseja mais se cadastrar e não quer mais receber nossas mensagens via 
        e-mail, basta clicar no botão abaixo.</p>
        <div class="form-group">
          <form action="{{url('/')}}/precadcancelar" method="POST">
            @csrf
            <input type="hidden" name="precad_id" value="{{$precad->id}} ">
            <button type="submit" class="btn btn-danger btn-lg btn-block">Sem desejo cancelar</button>
          </form>
        </div>
    </div>
    <div class="col-md-4 mb-5">
      <img src="{{url('/')}}/img/taxasdeconvercao.png" alt="Mais vendas para você!">
  </div>
</div>
@endif

@if(isset($cancelado))
<div class="container">
  <div class="row">
    <div class="col-md-8 mb-5"> 
      <h2>Seu pré-cadastro foi cancelado</h2>
      <hr>
    
      <p>Agradecemos e nos colocamos a sua disposição.</p>
        
    </div>
    <div class="col-md-4 mb-5">
      <img src="{{url('/')}}/img/taxasdeconvercao.png" alt="Mais vendas para você!">
  </div>
</div>
@endif


@endsection
