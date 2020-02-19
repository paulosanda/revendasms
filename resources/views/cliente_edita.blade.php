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

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                          <h2>Editando
                              @if($cliente->nome != '')
                               {{$cliente->nome}}
                               @endif
                               @if($cliente->nome == '')
                               {{$cliente->telefone}}
                               @endif

                            </h2>
                            <hr>
                            <form action="{{ url('cliente_edita')}}" method="post">  
                                @csrf
                            <div class="form-group">
                                <label for="nome"><b class="ls-label-text">Nome</b></label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{$cliente->nome}}">
                            </div>
                            <div class="form-group">
                                <label for="nascimento"><b class="ls-label-text">Data de nascimento</b></label>
                                <input type="date" class="form-control" id="nascimento" name="nascimento" value="{{$cliente->nascimento}}">
                            </div>
                            <div class="form-group">
                                <label for="email"><b class="ls-label-text">E-mail</b></label>
                                <input type="text" class="form-control" id="email" name="email" value="{{$cliente->email}}">
                            </div>
                            <div class="form-group">
                                <label for="telefone"><b class="ls-label-text">Celular</b></label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="{{$cliente->telefone}}">
                            </div>
                            <div class="form-group">
                                <label for="sexo"><b class="ls-label-text">Sexo</b></label>
                                <input type="text" class="form-control" id="sexo" name="sexo" value="{{$cliente->sexo}}">
                                <small id="sexoHelp" class="form-text text-muted">As opções para sexo são M para masculino ou F para feminino</small>
                            </div>
                            <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                            <button type="submit" class="btn btn-primary">Alterar</button>
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