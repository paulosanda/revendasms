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
                            <h2>Cancelando pedido de recarga - {{$pedido['id']}}</h2>
                            <hr>
                            <div>
                            <p class="div-text"> {{$empresa['nome']}}</p>
                            <p class="div-text">Você está cancelando o pedido de recarga: {{number_format($pedido['quantidade'])}} envios</p>
                            <p class="div-text">O pedido foi realizado por {{$user['name']}}</p>                            
                            </div>
                            <div>
                                <a class="btn btn-danger" href="/cancelar_confirma/{{$pedido['id']}}" role="button">Confirma cancelamento</a>
                            </div>
                          </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection