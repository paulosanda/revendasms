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
                            <h2>Cadastre a empresa</h2>
                            <hr>
                            <form action="cad_empresa" method="post" enctype="multipart/form-data">  
                                @csrf
                            <div class="form-group text-left">
                                <label for="nome">Nome da empresa: </label>
                                <input type="text" class="form-control" id="nome" name="nome">
                            </div>
                            <div class="form-group text-left">
                                <label for="cnae">CNAE: </label>
                                <input type="text" class="form-control" id="cnae" name="cnae">
                            </div>
                            <div class="form-group text-left">
                                <label for="endereco">Endereço: </label>
                                <input type="text" class="form-control" id="endereco" name="endereco">
                            </div>
                            <div class="form-group text-left">
                                <label id="cidade" for="cidade">Cidade</label>
                                <input type="text" class="form-control" name="cidade" id="cidade">           
                              </div>
                            <div class="form-group text-left">
                                <label id="estado" for="estado">Estado</label>
                                <input type="text" class="form-control" name="estado" id="estado">
                            </div>
                            <div class="form-group text-left">
                                <label for="documento">CPF ou CNPJ: </label>
                                <input type="text" class="form-control" id="documento" name="documento">
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="arquivo" name="arquivo">
                                <label class="custom-file-label" for="arquivo">O arquivo deve ter no máximo 50px de altura por 150px de largura</label>
                              </div>

                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection