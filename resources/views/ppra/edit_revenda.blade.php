@extends('ppra.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar revenda</div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            
                            <div>
                                @if(isset($empresa->logo))
                                <img src="{{url('/')}}/storage/{{$empresa->logo}} " alt="Logo">
                                @endif
                            {{$empresa->nome}}
                            </div>
                            <form action="{{url('/')}}/alt_revenda" method="post" enctype="multipart/form-data">  
                                @csrf
                                <input type="hidden" name="id" value="{{$empresa->id}}">
                            <div class="form-group text-left">
                                <label for="name">Nome da empresa: </label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$empresa->nome}}">
                            </div>
                            <div class="form-group text-left">
                                <label for="cnae">CNAE: </label>
                                <input type="text" class="form-control" id="cnae" name="cnae" value="{{$empresa->cnae}}">
                            </div>
                            <div class="form-group text-left">
                                <label for="endereco">Endereço: </label>
                                <input type="text" class="form-control" id="endereco" name="endereco" value="{{$empresa->endereco}}">
                            </div>
                            <div class="form-group text-left">
                                <label for="cidade">Cidade: </label>
                                <input type="text" class="form-control" id="cidade" name="cidade" value="{{$empresa->cidade}}">
                            </div>
                            <div class="form-group text-left">
                                <label for="uf">Estado: </label>
                                <input type="text" class="form-control" id="uf" name="uf" value="{{$empresa->uf}}">
                            </div>
                            <div class="form-group text-left">
                                <label for="documento">CPF ou CNPJ: </label>
                                <input type="text" class="form-control" id="documento" name="documento" value="{{$empresa->documento}}">
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="arquivo" name="arquivo">
                                <label class="custom-file-label" for="arquivo">O arquivo deve ter no máximo 50px de altura por 150px de largura</label>
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