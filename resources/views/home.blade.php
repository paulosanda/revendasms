@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa->logo))
                    <img src="{{ url('storage/').'/'.$empresa->logo}} " alt="Logo">
                    @endif
                    @if(!isset($empresa->logo))
                    @if(Auth::user()->is_admin < 1)
                     <span>{{$empresa->nome}}</span>
                    @endif
                     @endif
                </div>

                <div class="card-body">
                    
                    <h5>Olá {{Auth::user()->name}}</h5>
                    @if(Auth::user()->status == 0)
                    <div class="text text-danger">
                    <p>Seu usuário está bloqueado entre em contato com a administração do sistema</p>
                    </div>
                    @endif
                    @if(Auth::user()->status == 1)
                    <p class="div-text">Sua empresa tem {{$cli_num}} contatos cadastrados atualmente.</p>
                    <p class="div-text">Seu saldo de envios é de {{$saldo->saldo}}.</p>
                   @endif
                   @if(Auth::user()->is_admin == 1)
                   <p class="div-text"><a class="btn btn-primary" href="{{url('/')}}/dashsms" role="button">Acessar painel administrativo de sua revenda</a> </p>
                   @endif
<!-- -------------------------para aceite de termos----------------------------- -->
                   @if(Auth::user()->status == 3)<!-- Revenda -->
                   <p class="div-text">Seja bem vindo.</p>
                   <p class="div-text">Para iniciar é preciso que você leia e aceite os termos.</p>
                   
                   <form action="{{url('/')}}/termoaceite" method="post">
                                            
                    <div class="form-group text-left">
                        <label for="termo">TERMOS DE USO DO SERVIÇO DUOPR</label>
                        <textarea  name="termo" id="termo" class="form-control" rows="10" cols="60" readonly="true" onscroll="botao()">
                            TERMOS DE USO DO SERVIÇO DUOPR
Agradecemos por escolher nossos serviços antes de iniciar sua, por favor, leia com atenção o este termo de uso. 
A plataforma de revenda DuoPR são oferecidos para as revendas mediante pagamento do setup e mensalidade do serviço, o atraso superior a 10 dias nas mensalidades podem acarretar no bloqueio do serviço para a revenda.
Os serviços oferecidos são
- Cadastro de clientes(tratados como empresas), cadastro de usuários para os clientes.
- Controle de créditos, podendo creditar envios para os clientes, também através de solicitação pelos clientes, controle de saldo geral da revenda e saldo total em clientes, bem como na listagem de clientes os saldos individuais de cada cliente.
- O conteúdo das mensagens são de responsabilidade daquele que a escreve, no caso os clientes das revendas, a DuoPR não faz a triagem de mensagens nem oferece aos revendedores esta possibilidade.

Os pagamentos das mensalidades são feitas por boleto de cobrança, para os créditos existem três opções, a transferência bancária, o boleto de depósito, ou o boleto de cobrança. No caso de transferência bancária ou boleto de depósito é necessário o envio do comprovante para a DuoPR conforme canal estabelecido, no caso de boleto de cobrança é acrescido ao valor a taxa referente a cobrança. 

Os direitos intelectuais do software é de propriedade da DuoPR, sendo cedido o uso para a revenda na modalidade de locação mensal.

A segurança de dados e saldo de envios e envio de mensagens é feita através de camadas de software na autenticação do usuário,  a senha é a chave para esta segurança portanto é sugerido ao cliente uma senha forte(8 caracteres com letras de caixa alta e baixa, números e caracteres especiais), a segurança desta senha depende do usuário. Este senha pode ser redefinida pelo usuário porém orientasse que siga a política de senha forte, também é importante que guarde a senha de forma segura e não a divulgue.
                        </textarea>
                    </div>
                    
                    <div class="form-group text-left" id="aceite">
                        <p>Para aceite leia o termo</p> 
                        
                    </div>  
                    @csrf
                                     
                    </form>
                  
                
                   @endif
<!--- ------------------------------- Fim do aceite ---------------------  ------>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')
<script>
   
    /*$('textarea').scroll(function()
    {
        submit.innerHTML = '<input type="submit" class="btn btn-primary btn-sm active" value="Aceito">'
    }) 
    
    document.getElementById('termo').onscroll = function(){botaoaceite()}*/
    
    function botao()
    {
        var submit = document.getElementById('aceite')
        submit.innerHTML = '<input type="submit" class="btn btn-primary btn-sm active" value="Concordo">'
        
    } 
    
    </script>
@endsection
