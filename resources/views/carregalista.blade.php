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
                    @if(!isset($empresa->logo))
                    {{$empresa['nome']}}
                    @endif
                    <span style="float:right">Carregar Lista</span>

                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            <div class="card">
                                <p class="card-text">O arquivo deve ser CSV, os campos devem ser separados
                                    preferencialmente por ";".</p>
                                <p class="card-text">Os Headers ou cabeçario, que é a primeira linha do arquivo que 
                                    indica o nome do campo devem ser sempre em caixa baixa(letras minúsculas), mais
                                    mais informações <a href="#instrucoes"> abaixo</a>.
                                </p>
                            </div>
                            <hr>
                            @if(isset($grupo))
                            <p class="div-text">O grupo {{$grupo}} foi criado com sucesso.<br>
                            Deseja carregar uma lista de contatos agora?
                            <br><strong>ATENÇÃO! </strong> a lista que você carregar agora será inserida no grupo criado.
                            <br>Se deseja enviar uma lista sem grupo ou para outro grupo clique 
                            <a href="/carregalista"> aqui</a>.
                            </p>
                            @endif
                            <form action="/carregalista" method="post" enctype="multipart/form-data">  
                                @csrf
                                <div class="form-group text-left">
                                    <label for="name">Campos que irá utilizar: </label><br>
                                   Nome: <input type="checkbox" checked name="cnome" value="1"><br>
                                   Telefone: <input type="checkbox" checked name="ctelefone" value="1"> (Campo obrigatório não desmarque)*<br>
                                   E-mail: <input type="checkbox" name="cemail" value="1"><br>
                                   Data de nascimento: <input type="checkbox" name="cnascimento" value="1"><br>
                                  
                                </div> 
                                @if(isset($gruposcontatos[0]['id']))
                                <div class="form-group">
                                    <label for="grupo_contato">Deseja inserir esta lista em algum grupo de contatos?</label>
                                    <select class="form-control" id="grupo_contato" name="grupo_contato">
                                        <option value="none">Não inserir em nenhum grupo</option>
                                        @foreach ($gruposcontatos as $gc)
                                        
                                        <option value="{{$gc->id}} ">{{$gc->tipo_grupo}} </option>
                                        
                                        @endforeach
                                    </select> 
                                </div>
                             @endif
                             @if(!isset($gruposcontatos[0]['id']))
                             <input type="hidden" name="grupo_contato" value="none">
                             @endif
                            <div class="custom-file">
                                @if(isset($grupo_id))
                                <input type="hidden"  id="grupo_contato" name="grupo_contato" value="{{$grupo_id}}">
                                @endif
                                <input type="file" class="custom-file-input" id="arquivo" name="arquivo">
                                <label class="custom-file-label" for="arquivo">Arquivo a ser carregado: </label>
                              </div>

                            <button type="submit" class="btn btn-primary">Carregar</button>
                        </form>
                          </div>
                          @if($errors->any())            
    <div class="card">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
                      -----  {{ $error }} ------
        </div>
        @endforeach                   
    </div>
    @endif
                          <div class="card"><a name="instrucoes">
                            <p class="div-text">* o campo telefone não é um campo opcional, você pode carregar um arquivo somente com este campo mas nunca sem ele.
                            <p class="div-text">A sequencia das informações no arquivo devem seguir a mesma sequencia dos campos escolhidos; exemplo:</p>
                            <p class="div-text">Se marcou o campos:</p>
                                <ul>
                                    <li>Nome</li>
                                    <li>Telefone</li>
                                    <li>Data de Nacimento</li>
                                    <li>Email</li>
                                    
                                </ul>
                            <p class="div-text">O formato obrigatório para o arquivo é CSV.</p>
                            <p class="div-text">Em seu arquivo os dados devem estar nesta sequencia e com estes headers; exemplo:</p>
                            <p class="div-text">nome ; telefone ; nascimento; e-mail<br>
                                Ana Silva; 11997975544; 10/11/1987; anasilva@gmail.com</p>
                            <p>Atenção os Headers devem ser em letras minúsculas(caixa baixa)</p>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection