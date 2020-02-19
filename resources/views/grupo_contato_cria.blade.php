@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa->logo))
                    <img src="storage/{{$empresa->logo}} " alt="Logo">
                    @endif
                    {{$empresa['nome']}}</div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            <h2>Criar Grupos de Contatos</h2>
                            <hr>
                            <p class="div-text">
                                Você pode criar grupos de contatos para melhor administrar seus envios, avalie sua estratégia 
                                ou necessidades para criar os grupos, ao inserir os contatos você pode escolher em qual(is) 
                                grupo(s) você deseja que pertençam.</p>
                            @if(isset($grupo_existe))
                            <p class="div-text">O grupo {{$grupo}} já existe.</p>  
                            @endif  
                            @if(isset($grupo_contato[0]['id']))    
                            <p class="div-text">No momento você tem os seguintes grupos</p>
                            @foreach ($grupo_contato as $ga)
                            <form method="post" action="grupo_contato_edita">
                                @csrf
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{$ga->id}} ">
                                <input type="text" name="grupo_tipo" value="{{$ga->tipo_grupo}}">
                                <input class="btn btn-primary" type="submit" value="Editar">  
                            </div>
                            </form> 
                            @endforeach
                            @endif
                            @if(empty($grupo_contato))
                            <p class="div-text">No momento você não tem nenhum grupo cadastrado</p>
                            @endif
                            
                            <form action="grupo_contato_cria" method="post">  
                                @csrf
                            <div class="form-group text-left">
                                <label><b class="ls-label-text">Nome do grupo</b></label><br>
                                <input type="text" id="grupo" name="grupo">
                            </div>
                            <button type="submit" class="btn btn-primary">Criar grupo</button>
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