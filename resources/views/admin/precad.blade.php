@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                @if(isset($sucesso))
                <div class="card-header"><h2>O cadastro foi realizado com sucesso e o prospect avisado via e-mail e SMS.</h2>
                <p>Deseja cadastrar outro?</p>
                </div>
                @endif
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            <h2>Pré cadastro de usuário</h2>
                            <hr>
                            <form action="{{url('/')}}/precad" method="post">  
                                @csrf
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Celular:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" required>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
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