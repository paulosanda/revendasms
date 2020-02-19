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
                            <h2>Carga de disparos realizada</h2>
                            <hr>
                            @foreach ($empresa as $empresa)
                            <div>
                                @if(isset($empresa->logo))
                                <img src="/storage/{{$empresa->logo}} " alt="Logo">
                                @endif
                            <p class="div-text"> {{$empresa['nome']}}</p>
                            <p class="div-text">Recarga realizada com sucesso</p>
                            <p class="div-text">Saldo atual = {{$empresa['disparo']['saldo']}} </p>
                            </div>
                            @endforeach
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection