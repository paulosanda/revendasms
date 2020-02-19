@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa->logo))
                    <img src="{{url('storage').'/'.$empresa->logo}} " alt="Logo">
                    @endif
                    {{$empresa['nome']}}
                </div>
                @if(isset($cliente))
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                          <h2>Você esta apagando o contato 
                              @if($cliente->nome != '')
                               {{$cliente->nome}}
                               @endif
                               @if($cliente->nome == '')
                               {{$cliente->telefone}}
                               @endif
                            </h2>
                            
                            <hr>
                            <form action="{{ url('cliente_apaga')}}" method="post">  
                                @csrf
                            <div>
                                @if(isset($cliente->nome))
                                <p class="div-text">Nome: {{$cliente->nome}}</p>
                                @endif
                                @if(isset($cliente->nascimento))
                                <p class="div-text">Data de nascimento: {{$cliente->nascimento}}</p>
                                @endif
                                @if(isset($cliente->email))
                                <p class="div-text">E-mail: {{$cliente->email}}</p>
                                @endif
                                <p class="div-text">Celular: {{$cliente->telefone}}</p>
                                @if(isset($cliente->sexo))
                                <p class="div-text">Sexo: {{$cliente->sexo}}</p>
                                @endif
                            </div>
                            <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                            <button type="submit" class="btn btn-primary">Apagar</button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(isset($delete))
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                          <h2>Contato Apagado</h2>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection