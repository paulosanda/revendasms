@extends('ppra.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Alterar dados de usuário de revenda</div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                           
                            <form action="{{url('/')}}/revenda_user_alt" method="post">  
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
                                <label for="status">Alterar Status: </label>
                                <select name="status">
                                    @if($user->status == 0)
                                    <option value="0" selected>Usuário bloqueado - se não alterar continuará neste status</option>
                                    <option value="1">Desbloquear usuário</option>
                                    @endif
                                    @if($user->status == 1)
                                    <option value="1" selected>Usuário ativo</option>
                                    <option value="0">Bloquear usuário</option>
                                    @endif
                                    @if($user->status == 2 || $user->status ==3)
                                    <option value="" selected>Sem aceite de termos. Deseja bloquear ou ativar?</option>
                                    <option value="0">Bloquear usuário</option>
                                    <option value="1">Ativar usuário</option>
                                    @endif
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