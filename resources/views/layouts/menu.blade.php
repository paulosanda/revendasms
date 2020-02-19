<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="SEO ADM - SMS Marketing">
  <meta name="author" content="Paulo Sanda">

  <title>SEO ADM</title>

  <!-- Bootstrap core CSS -->
  <link href="{{url('')}}/css/app.css" rel="stylesheet">


  <!-- Custom styles for this template -->

  <script src="{{ asset('js/app.js') }}" defer></script>

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
    <div id='app'></div>
  <!-- Navigation -->
 
  <div id="menu">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
      <div class="container">
          <a class="navbar-brand" href="{{ url('/home') }}">
              <img src="{{ url('img/logo.png')}}">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Left Side Of Navbar -->
              <ul class="navbar-nav mr-auto">

              </ul>

              <!-- Right Side Of Navbar -->
              <ul class="navbar-nav ml-auto">
                 
                  <!--- Início de novos menus --->
         

                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          Conta <span class="caret"></span>
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{url('/login')}}">Login</a>
                         
                      </div>
                  </li>

                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                           <span class="caret">Contato</span>
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ url('/')}}/#contato">Entre em contato agora!</a> 
                         
                      </div>
                  </li>



                  <!--- Fim de novos menus --->
                      
                  
              </ul>
          </div>
      </div>
  </nav>
  </div>
  
    <main class="py-0">
            @yield('contenteudo')
    </main>
 

      

  <!-- Footer -->
  <footer class="py-2 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; SEO ADM 2020 - SÃO PAULO</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  
  <script src="{{url('/')}}/jquery/jquery.min.js"></script>
  <script src="{{url('/')}}/jquery-easing/jquery.easing.min.js"></script>
  <script src="{{url('/')}}/js/pp.js"></script>
  @if(isset($bemvindo))
<script src="{{url('/')}}/js/bemvindomodal.js "></script>
  @endif

</body>

</html>