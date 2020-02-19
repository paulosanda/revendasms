@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa->logo))
                    <img src="storage/{{$empresa->logo}} " alt="Logo">
                    @endif
                    @if(!isset($empresa->logo))
                    {{$empresa['nome']}}
                    @endif
                    <span style="float:right">Pedido de envios</span>
                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            <h2>Pedido realizado</h2>
                            <hr>
                            <p class="div-text">O pedido de {{$quantidade}} envios foi realizado.</p>
                            <p class="div-text">Entraremos em contato em breve para confirmar sua solicitação.</p>
                            <p class="div-text">Obrigado.</p>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection