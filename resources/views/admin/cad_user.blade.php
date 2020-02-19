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
                            <h2>Cadastre usuário</h2>
                            <hr>
                            <form action="cad_user" method="post">  
                                @csrf
                            <div class="form-group text-left">
                                <label for="name">Nome: </label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group text-left">
                                <label for="telefone">Celular: </label>
                                <input type="text" class="form-control" id="celular" name="celular" required>
                            </div>
                            <div class="form-group text-left">
                                <label for="email">Email: </label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group text-left">
                                <label for="empresa">empresa: </label>
                                <select class="form-control" id="empresa" name="empresa">
                                    <option value="null">Escolha a empresa</option>
                                    @foreach ($empresa as $e)
                                    <option value="{{$e->id}}">{{$e->nome}}</option>                                        
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group text-left">
                                <label for="password">Senha: </label>
                                <input type="password" class="form-control" id="password" name="password" required>
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