@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">

                          <div class="col-md-12 mb-5">
                            <h2>Atendimento de pedido de recarga - {{$pedido[0]['id']}}</h2>
                            <hr>
                            <div>
                            <p class="div-text"> {{$empresa[0]['nome']}}</p>
                            <p class="div-text">Solicitação de recarga: {{number_format($pedido[0]['quantidade'])}} envios</p>
                            <p class="div-text">O pedido foi realizado por {{$user[0]['name']}}
                                <br>E-mail: {{$user[0]['email']}}
                                <br>Telefone: {{$user[0]['telefone']}}
                                @if($pedido[0]['status'] == 'Boleto enviado')
                                <br>Valor do boleto: R$ {{number_format($valor, 2, ',', '.')}}
                                @endif
                            </p>                            
                            </div>
                            <form action="{{ url('/recarga_atendimento')}}" method="post">  
                                @csrf
                            <input type="hidden" name="empresa_id" value="{{$empresa[0]['id']}}">
                            <input type="hidden" name="pedido_id" value="{{$pedido[0]['id']}}">
                            <input type="hidden" name="quantidade" value="{{$pedido[0]['quantidade']}}">
                            @if($pedido[0]['status'] == 'Aguardando atendimento')
                            <div class="form-group text-left">
                                <label for="v_unit">Valor por envio: </label>
                                <input type="text" class="form-control" id="v_unit" name="v_unit">
                            </div>
                            @endif
                            @if($pedido[0]['status'] == 'Aguardando atendimento')
                            <input type="hidden" name="status" value="Boleto enviado">
                            <button type="submit" class="btn btn-primary">Confirmar envio do boleto</button>
                            <a class="btn btn-danger" href="{{ url('/cancelar_pedido/').'/'.$pedido[0]['id']}}" role="button">Cancelar pedido</a>
                            @endif
                            @if($pedido[0]['status'] == 'Boleto enviado')
                            <input type="hidden" name="status" value="Finalizado">
                            <input type="hidden" name="v_unit" value="{{$pedido[0]['valor_unit']}}">
                            <button type="submit" class="btn btn-primary">Finalizar e creditar</button>
                            <a class="btn btn-danger" href="/cancelar_pedido/{{$pedido[0]['id']}}" role="button">Cancelar pedido</a>
                            @endif

                        </form>
                          </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection