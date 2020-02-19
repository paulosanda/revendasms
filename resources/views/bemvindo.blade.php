@extends('layouts.menu')
@section('contenteudo')

<!-- modal de abertura -->

<div id="psModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header"><h4 class="modal-title">{{session('nome')}} </h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
              <p>Foi enviado para seu celular o código para que vocẽ possa se autenticar 
                e prosseguir o cadastro.<br>
              Por favor aguarde alguns instantes.</p>
          </div>
      </div>
  </div>
</div>  

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
<!-- Page Content 1 -->
@if(!isset($multi))
@if(session('success') == 1)
<div class="container">
  <div class="row">
    <div class="col-md-8 mb-5"> 
      <h2>{{session('nome')}}, tudo bem?</h2>
      <hr>
      @if(!session('erro'))
      <p>Em alguns momentos você vai receber um código via SMS em seu celular.<br>
        Por favor aguarde.  </p>
      <p>Se por algum motivo não receber o código, pode haver algum problema em 
          seu cadastro por favor entre em contato com o consultor que lhe atendeu ou 
          pelo e-mail suporte@seo.adm.br.    
      @endif
      @if(session('erro'))
      <p>{{session('erro')}}</p>
      @endif
    </div>
    <div class="col-md-4 mb-5">
      <h2>Insira o código que você recebeu</h2>
      <hr>  
      @if($errors->any())            
      <div class="card">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
          {{ $error }}
        </div>          
        @endforeach  
      </div>
      @endif 
        <form action="{{url('/')}}/codigoverifica" method="post">  
          @csrf
        <input type="hidden" name="email" value="{{session('email')}}">
        <input type="hidden" name="id" value="{{$dados->id}}">
        <div class="form-group">
          <label for="codigo">Código: </label>
          <input type="text" class="form-control" id="codigo" name="codigo">
        </div>
        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6LdfUdAUAAAAAAaCZUAOlRURgCgmIFXwappPB5lp"></div>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>                 
      </div>
    </div>
</div>
@endif
@endif
@if(isset($multi))
<div class="row">
  <div class="col-md-10"><h3>{{$multi}} </h3></div>
</div>
@endif
<!-- Page Content 3 Cadastrar empresa -->
@if(session('success') == 2)
<div class="container">
  <div class="row">
    <div class="col-md-8 mb-5"> 
      <h2>Cadastre sua empresa</h2>
      <hr>
      <p>Agora vamos abrir a conta de sua empresa. </p>
      <p>Nem todos os campos são obrigatórios, se não tiver os dados no momento, preencha somente
        os campos obrigatórios as demais informações podem ser completadas depois.</p>
      <p>Se você tiver a mão o logo de sua empresa pode enviar no cadastro, mas ele deve ter no máximo
        50px de altura por 150px de comprimento. Caso não tenha não precisa enviar agora.</p>    
    </div>
    <div class="col-md-4 mb-5">
      <h2>Sua empresa</h2>
      <hr>  
      @if($errors->any())            
      <div class="card">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
        @endforeach  
      </div>
      @endif        
      <form action="{{url('/')}}/precadEmpresa" method="post" enctype="multipart/form-data">  
        @csrf
        <input type="hidden" name="email" value="{{session('email')}}">
      <div class="form-group text-left">
        <label for="nome">Nome da empresa: </label>
        <input type="text" class="form-control" id="nome" name="nome" required>
        <small id="nomeHelp" class="form-text text-muted">Campo obrigatório</small>
      </div>
      <div class="form-group text-left">
        <label for="cnae">CNAE: </label>
        <input type="text" class="form-control" id="cnae" name="cnae">
      </div>
      <div class="form-group text-left">
        <label for="endereco">Endereço: </label>
        <input type="text" class="form-control" id="endereco" name="endereco">
      </div>
      <div class="form-group">
        <label id="estado" for="estado">Estado</label>
        <select class="form-control" name="estado" id="estado">
        @if(isset($estado))
        @foreach($estado as $uf)
        <option value="{{$uf->id}}">{{$uf->estado}}</option>
        @endforeach
          @endif
        </select>
        <label id="cidade" for="cidade">Cidade</label>
        <select class="form-control" name="cidade" id="cidade">            
        <option value=""></option>           
        </select>
      </div>
      <div class="form-group text-left">
        <label for="arquivo">Logo: </label>
        <input type="file" class="form-control" id="arquivo" name="arquivo">
        <small id="fileHelp" class="form-text text-muted">Tamanho máximo 150px(largura) por 50px(altura) formatos JPG ou PNG</small>
      </div>
      <div class="form-group">
        <div class="g-recaptcha" data-sitekey="6LdfUdAUAAAAAAaCZUAOlRURgCgmIFXwappPB5lp"></div>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>                 
     </div>
  </div>
</div>
@endif

<!-- Page Content 4 Finalizar cadastro de usuário -->
@if(session('success') == 3)
<div class="container">
  <div class="row">
    <div class="col-md-8 mb-5"> 
      <h2>Estamos quase lá!</h2>
      <hr>
      <p>Agora conta de sua empresa foi aberta, agora vamos finalizar a criação de seu usuário.</p>
    
      <p>Seu usuário estará inicialmente bloqueado, o cadastro será avaliado e entraremos em contato.<br>
      Desculpe o incomodo mas é tudo para sua segurança.</p>    
    </div>
    <div class="col-md-4 mb-5">
      <h2>Cadastro de usuário para EMPRESA</h2>
      <hr>  
      @if($errors->any())            
      <div class="card">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
        @endforeach  
      </div>
      @endif        
      <form action="{{url('/')}}/precaduser" method="post">  
        @csrf
        <input type="hidden" name="empresa_id" value="{{$empresa_id}}">
        <input type="hidden" name="precad_id" value="{{session('precad_id')}}">
      <div class="form-group text-left">
        <label for="name">Nome: </label>
        <input type="text" class="form-control" id="name" name="name" value="{{session('nome')}}" required>
        <small id="nomeHelp" class="form-text text-muted">Campo obrigatório</small>
      </div>
      <div class="form-group text-left">
        <label for="email">E-mail </label>
        <input type="email" class="form-control" id="email" name="email" value="{{session('email')}}" required>
      </div>
      <div class="form-group text-left">
        <label for="telefone">Celular: </label>
        <input type="text" class="form-control" id="telefone" value="{{session('telefone')}}" name="telefone" required>
      </div>
      <div class="form-group text-left">
        <label for="senha">Senha: </label>
        <input type="password" class="form-control" placeholder="Senha" id="password"  name="password" required>
      </div>
      <div class="form-group text-left">
        <label for="confirm_password">Confirme a sua senha </label>
        <input type="password" class="form-control" placeholder="Confirme Senha" id="confirm_password" required>
      </div>
      
     
      <div class="form-group">
        <div class="g-recaptcha" data-sitekey="6LdfUdAUAAAAAAaCZUAOlRURgCgmIFXwappPB5lp"></div>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </form>                 
     </div>
  </div>
</div>
@endif

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
