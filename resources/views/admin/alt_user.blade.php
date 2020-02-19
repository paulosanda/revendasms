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
                            <h2>Alterar dados de usuário</h2>
                            <hr>
                            <form action="/alt_user" method="post">  
                                @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <div class="form-group text-left">
                                <label for="name">Nome: </label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                            </div>
                            <div class="form-group text-left">
                                <label for="email">Celular: </label>
                                <input type="text" class="form-control" id="celular" name="celular" value="{{$user->telefone}}">
                            </div>
                            <div class="form-group text-left">
                                <label for="email">Email: </label>
                                <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}">
                            </div>
                            <div class="form-group text-left">
                                <label for="empresa">empresa: {{$empresa->nome}} </label>
                            </div>
                            <div class="form-group text-left">
                                <label for="status">Tornar inativo: </label>
                                <select name="status">
                                    <option value="1" selected>Não</option>
                                    <option value="0">Sim</option>
                                </select>
                            </div>
                            <div class="form-group text-left">
                                <label for="password">Senha(preencha somente se for alterar a senha): </label>
                                <input type="password" class="form-control" id="password" name="password">
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