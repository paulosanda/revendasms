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
                            <h2>Fazer carga de disparos</h2>
                            <hr>
                            <div>
                                @if(isset($empresa->logo))
                                <img src="/storage/{{$empresa->logo}} " alt="Logo">
                                @endif
                            <p class="div-text"> {{$empresa[0]['nome']}}</p>
                            <p class="div-text">Saldo atual = {{$empresa[0]['disparo']['saldo']}} </p>
                            </div>
                            <form action="/recarga" method="post">  
                                @csrf
                            <input type="hidden" name="id" value="{{$empresa[0]['id']}}">
                                <div class="form-group text-left">
                                <label for="recarga">Numero de envios para carregar: </label>
                                <input type="number" class="form-control" id="recarga" name="recarga">
                            </div>
                            <button type="submit" class="btn btn-primary">Alterar</button>
                        </form>
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection