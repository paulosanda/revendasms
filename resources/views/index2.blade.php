<!DOCTYPE html>
<html lang="pt-br">


<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Paulo Sanda">

  <title>SEO</title>

  <!-- Bootstrap core CSS -->
  <link href="/css/app.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/business-frontpage.css" rel="stylesheet">

  <script src="https://www.google.com/recaptcha/api.js" ></script>

  <style>form .invalid{
    border: 1px solid #a70000;
    color: #a70000;
}
 
ul.errors{
    background-color: #eee;
    padding: 10px;
    color: #a70000;
    list-style-position: inside;
    display: inline-block;
    width: 250px;
}
 
.flash-success{
    background-color: #eee;
    color: #08a700;
    padding: 10px;
    display: inline-block;
    width: 250px;            
}</style>

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/"><img src="/img/logo.png"> </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>          
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contato">Contato</a>
          </li> 
        </ul>
      </div>
    </div>
  </nav>
  

 <!-- Header -->
 <header class="bg-primary py-5 mb-5" style="background-image:url(img/smsmkt.jpg)">
    <div class="container h-100">
      <div class="row h-100 align-items-center" style=" background-color: #006400; 
      posição:absoluta; z-index:-1; top:0; left:0; right:0; bottom:0; opacity:0.9;">
        <div class="col-lg-12">
          <h2 class="display-6 text-white mt-5 mb-2">Sua empresa sempre em contato com seus clientes</h2>
          <p class="lead mb-10 text-white-50">SMS É O MEIO DE COMUNICAÇÃO MAIS EFICIENTE PARA FALAR COM CLIENTES</p>
          <p class="lead mb-5 text-white-50">O SMS Marketing é uma sólida estratégia de marketing digital. Por meio de 
            mensagens de até 150 caracteres, a empresa divulga informações de seus produtos e serviços, 
            agradecimentos, promoções, parabenizações e muito mais.<br>
            O SMS Marketing tem baixo custo e ALTO RETORNO, pesquisas mostram que 90% das pessoas leem o SMS 
            em até 5 minutos a pós o recebimento.</p>

        </div>
      </div>
    </div>
  </header>

  <!-- Page Content -->
  <a id="contato">
  <div class="container">
    <div class="row">
      <div class="col-md-8 mb-5">
        
        <h2>Para sua empresa</h2>
        <hr>
        <p>Com a SEO você envia mensagens personalizadas. </p>
        <ul>
          <li> Para todos seus contatos</li>
          <li>Os aniversariantes do mês</li>
          <li>Aniversariantes do dia</li>
          <li>Cria e gerencia seus contatos por grupos</li>
        </ul>
        <p> Tudo isto de forma simples e fácil</p>

        <a class="btn btn-primary btn-lg" href="#">Com a SEO você pode!</a>
       


      </div>
      <div class="col-md-4 mb-5">
        @if (!$success = session('success'))
        <h2>Faça contato</h2>
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


        <form action="contato" method="post">  
          @csrf
        <div class="form-group">
            <label for="nome">Nome: </label>
            <input type="text" class="form-control" id="nome" name="nome"  
            class="{{ $errors->has('nome') ? 'invalid' : '' }}"  required          
            value="{{ old('nome') }}">
        </div>
        <div class="form-group">
            <label for="email">Email: </label>
            <input type="email" class="form-control" id="email" name="email"
            class="{{ $errors->has('email') ? 'invalid' : '' }}"  required          
            value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="celular">Celular: </label>
            <input type="text" class="form-control" id="celular" name="celular"
            class="{{ $errors->has('celular') ? 'invalid' : '' }}" required           
            value="{{ old('celular') }}">
        </div>
        <div class="form-group">
          <div class="g-recaptcha" data-sitekey="6LdfUdAUAAAAAAaCZUAOlRURgCgmIFXwappPB5lp"></div>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form> 
    @endif  
    @if ($success = session('success'))
    <div class="flash-success">{{ $success }}</div>
    
    @endif            
    </div>
  
      </div>
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-md-4 mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="/img/clientes.jpg" alt="">
          <div class="card-body">
            <h4 class="card-title">Vantagens do de SMS Marketing</h4>
            <p class="card-text">Em 2020 está previsto que 90% da população mundial 
              terá um  celular, o entendimento sobre o que é SMS Marketing e a compreensão das 
              estratégias para esse canal, se torna essencial para seu negócio.<br>
              Também,  pesquisas demonstram que as pessoas preferem se comunicar com as empresas 
              por meio de SMS, do que por outros canais. A maioria diz que prefere obter 
              alertas de status de pedidos, confirmações de reservas, promoções, 
              informações e lembretes de compromissos via texto.<br>
              O número de pessoas de telefones celulares quase triplicou na última década, 
              em 2018 o número já superava 5 bilhões de pessoas. Com mais celulares em mãos, 
              a eficácia do SMS está aumentando.
            </p>
          </div>
          
        </div>
      </div>
      <div class="col-md-4 mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="/img/emcontato.jpg" alt="">
          <div class="card-body">
            <h4 class="card-title">Os celulares se tornaram uma das maiores plataformas de marketing</h4>
            <p class="card-text">
              Um estudo realizado por psicólogos britânicos descobriu que os consumidores estão gastando 
              2 vezes mais tempo em seus celulares do que pensam que estão. 
              Estima-se que os usuários toquem seu smatphone 2.617 vezes por dia, ilustrando como a 
              segmentação de consumidores mobile pode ser o método mais direto de marketing.<br>
              Mais empresas estão se voltando para o SMS como sua escolha desejada de marketing móvel. 
              A <strong>Coca Cola</strong>, por exemplo, agora gasta 70% de seu orçamento de marketing mobile em serviços de SMS.
              
          </div>
          
        </div>
      </div>
      <div class="col-md-4 mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="/img/taxasdeconvercao.png" alt="">
          <div class="card-body">
            <h4 class="card-title">Altas taxas de conversão</h4>
            <p class="card-text">Há uma taxa média de resposta de 45% para mensagens SMS (o email tem apenas 8%), 
              mas o mais importante é que a interação com esses textos também é significativamente maior do que 
              em outras ferramentas de marketing.<br>
              É importante poder avaliar a eficácia de suas campanhas de marketing para entender de onde vêm seus 
              clientes. O marketing por SMS pode ser facilmente validado usando por exemplo encurtadores de URL com 
              o Bitly, pois além de tornar o endereço internet mais curto; o que é muito importante para economizar 
              caracteres em sua mensagem, fornecem estatísticas de cliques.</p>
          </div>
         
        </div>
      </div>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; SEO ADM 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  

</body>

</html>