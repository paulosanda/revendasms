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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h5>Olá {{Auth::user()->name}}</h5>
                    @if(Auth::user()->status < 1)
                    <div class="text text-danger">
                    <p>Seu usuário está bloqueado entre em contato com a administração do sistema</p>
                    </div>
                    @endif
                    @if(Auth::user()->status == 1)
                    <p class="div-text">Sua empresa tem {{$cli_num}} contatos cadastrados atualmente.</p>
                    <p class="div-text">Seu saldo de envios é de {{$saldo->saldo}}.</p>
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
