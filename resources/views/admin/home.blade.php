@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>Logado no sistema administrativo</div>
                    <div>O saldo geral de envios é </div>
                    <div>O total de saldos das empresas é {{$saldo_emp}}</div>
                    @if(isset($saldo_geral))
                    <div>Você tem {{$saldo_geral->saldo_geral}} envios em estoque (saldo geral)</div>
                    @endif
                    <div>Ajustar saldo geral</div>
                    <form action="adminps" method="post">
                        @csrf
                        <div class="form-group text-left">
                            <label for="qtidade">Quantidade</label>
                            <input class="form-control" type="number" name="qtidade" id="qtidade">
                            <small id="qtidadeHelp" class="form-text text-muted">
                                Se for somar saldo basta digitar a quantidade, para dimuir o saldo
                                coloque o sinal "-" para subtrair.
                            </small>
                        </div> 
                        <button type="submit" class="btn btn-primary">Ajustar</button>
                    </form>                  
                </div>
            </div>    
        </div>
    </div>
</div>
@endsection