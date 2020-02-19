@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa[0]['logo']))
                    <img src="{{ url('storage/').'/'.$empresa[0]['logo']}} " alt="Logo">
                    @endif
                    @if(!isset($empresa[0]['logo']))
                     <span>{{$empresa[0]['nome']}}</span>
                     @endif
                     <span style="float:right">DADOS GERAIS DA CONTA</span>
                </div>
                <div class="card-body">

                    @foreach ($empresa as $e)
                    <div class="container">

                        <div class="row">
                            <div class="col-md-4 mb-5">
                                <h3> Usuários </h3>
                                @foreach ($e->listUser as $u)
                                <p class="div-text">{{$u->name}} <br>
                                   {{$u->email}}
                                </p>
                                @endforeach
                            </div>
                            <div class="col-md-4 mb-5">
                                <h3> Saldo de envios </h3>
                                <p class="div-text">{{$e->disparo->saldo}}</p>
                            </div>
                            <div class="col-md-4 mb-5">
                                <h3> Contatos </h3>
                                <p class="div-text">{{$clientes}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <a class="btn btn-primary" href="pedido_recarga" role="button">Solicitar pacote de envios</a>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection