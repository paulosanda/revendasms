@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastro de usuário de revenda</div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            <!--- se for cadastro de primeiro usuário da revenda -->
                            @if(isset($revenda_nome))
                            <h2>Cadastrando primeiro usuário para revenda {{$revenda_nome}} </h2>
                            <hr>
                            @endif
                            <form action="cad_user_revenda" method="post">  
                                @csrf
                            <div class="form-group text-left">
                                <label for="name">Nome: </label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group text-left">
                                <label for="telefone">Celular: </label>
                                <input type="text" class="form-control" id="telefone" name="telefone" required>
                            </div>
                            <div class="form-group text-left">
                                <label for="email">Email: </label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <!-- para cadastro avulso de usuário -->
                            @if(isset($empresa))
                            <div class="form-group text-left">
                                <label for="empresa">empresa: </label>
                                <select class="form-control" id="empresa" name="empresa">
                                    <option value="null">Escolha a empresa</option>
                                    @foreach ($empresa as $e)
                                    <option value="{{$e->id}}">{{$e->nome}}</option>                                        
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <!-- se for primeiro usuário da revenda -->
                            @if(isset($empresa_id))
                            <input type="hidden" name="empresa_id" value="{{$empresa_id}}">
                            @endif
                            <div class="form-group text-left">
                                <label for="password">Senha: </label>
                                <input type="text" class="form-control" id="password" name="password" value="{{$sugere_passwd}}" required>
                                <small id="passwordHelp" class="form-text text-muted">Recomenda-se manter a senha sugerida</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection