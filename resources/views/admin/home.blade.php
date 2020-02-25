@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Painel administrativo de {{$revenda->nome}} </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>Logado no sistema administrativo</div>
                    <div>O saldo total(seu estoque mais saldo em clientes) de envios é {{$saldo_geral->saldo_geral + $saldo_emp}} </div>
                    <div>O total de saldos das empresas é {{$saldo_emp}}</div>
                    @if(isset($saldo_geral))
                    <div>Você tem {{$saldo_geral->saldo_geral}} envios em estoque (saldo geral)</div>
                    @endif        
                </div>
            </div>    
        </div>
    </div>
</div>
@endsection