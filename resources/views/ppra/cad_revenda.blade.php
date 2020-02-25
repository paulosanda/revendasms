@extends('ppra.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastro de nova revenda</div>
                <div class="card-body">
                    <form action="cad_revenda" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group text-left">
                            <label for="nome">Nome da empresa</label>
                            <input class="form-control" type="text" name="nome" id="nome" required>
                        </div> 
                        <div class="form-group text-left">
                            <label for="cnae">CNAE</label>
                            <input class="form-control" type="text" name="cnae" id="cnae">
                        </div>
                        <div class="form-group text-left">
                            <label for="documento">CNPJ ou CPF</label>
                            <input class="form-control" type="text" name="documento" id="documento">
                        </div>
                        <div class="form-group text-left">
                            <label for="endereco">Endereço</label>
                            <input class="form-control" type="text" name="endereco" id="endereco">
                        </div>
                        <div class="form-group text-left">
                            <label for="cidade">Cidade</label>
                            <input class="form-control" type="text" name="cidade" id="cidade">
                        </div>
                        <div class="form-group text-left">
                            <label for="estado">Estado</label>
                            <input class="form-control" type="text" name="estado" id="estado">
                        </div>
                        <div class="form-group text-left">
                            <label for="logo">Logo</label>
                            <input class="form-control" type="file" name="arquivo" id="arquivo">
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>                  
                </div>
            </div>    
        </div>
    </div>
</div>
@endsection