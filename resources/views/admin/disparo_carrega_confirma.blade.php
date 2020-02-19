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
                            <h2>Confirmar carga de disparos</h2>
                            <hr>
                            <div>
                                @if(isset($empresa->logo))
                                <img src="/storage/{{$empresa->logo}} " alt="Logo">
                                @endif
                            <p class="div-text"> {{$empresa['nome']}}</p>
                            <p class="div-text">Saldo atual = {{$empresa['disparo']['saldo']}} </p>
                            <p class="div-text">Você está inserindo {{$recarga}} disparos.</p>
                            <p class="div-text">O novo saldo será {{$qtidade}}.</p>
                            </div>
                            <form action="/recarga_confirma" method="post">  
                                @csrf
                            <input type="hidden" name="id" value="{{$empresa['id']}}">
                            <input type="hidden" name="qtidade" value="{{$qtidade}}">
                            <input type="hidden" name="recarga" value="{{$recarga}}">
                            <button type="submit" class="btn btn-primary">Confirmar carga</button>
                        </form>
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection