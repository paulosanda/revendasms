@extends('ppra.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard PPRA</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>Logado no sistema administrativo PPRA</div>
                    <div>O saldo geral de envios em todo o sistema é {{$saldo_geral}} envios</div>
                    
                    @if(isset($useralt))
                    <div><strong> Usuário alterado com sucesso</strong></div>
                    @endif
                    
                                
                </div>
            </div>    
        </div>
    </div>
</div>
@endsection