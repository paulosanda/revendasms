@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> @if(isset($empresa->logo))
                    <img src="storage/{{$empresa->logo}} " alt="Logo">
                    @endif
                    {{$empresa['nome']}}
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <h3>Relatório de lista carregada em {{strftime("%d/%m/%Y %H:%M", strtotime($lista_a[0]['updated_at']))}}</h3>
                            <hr>                            
                        </div>
                        <form method="post" action="apaga_lista">
                        <div class="row">
                            <table class="table">
                                <thead>
                                    <th>Nome</th>
                                    <th>Nascimento</th>
                                    <th>E-mail</th>
                                    <th>Celular</th>
                                    <th>Sexo</th>
                                    <th>Observação</th>
                                </thead>
                               
                                <tbody>
                                    @foreach ($lista_a as $li)
                                    <tr> 
                                        <td>{{$li->cliente_nome}}</td>
                                        <td>{{$li->cliente_nascimento}}</td>
                                        <td>{{$li->cliente_email}}</td>
                                        <td>{{$li->cliente_telefone}}</td>
                                        <td>{{$li->cliente_sexo}}</td>
                                        <td>{{$li->observacao}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                        </div>
                        <div class="row">
                            <div class="col shadow p-3 mb-5 bg-white rounded">
                            <input type="hidden" name="carga_id" value="{{$carga_id}}">
                            @csrf
                            <p class="div-text">Encontrou erros nesta lista?<br>
                            Apague e carregue novamente.<br>
                            Os contatos que foram gravados apenas para grupo (ver no campo observação) não serão apagados
                            , apenas retirados do grupo.<br>
                            Isto acontece pois o numero já estava na base.</p>
                            <input class="btn btn-danger" type="submit" value="Apagar">
                            </div>
                            <div class="col col shadow p-3 mb-5 bg-white rounded">
                                <p class="div-text">Caso o erro persista, envie para o <strong>suporte@seo.adm.br</strong>
                                    para que possamos analisar o arquivo.</p>
                            </div>
                        </div>
                    </form>
                    </div>
                </div> 
            </div> 
        </div>
    </div>
</div>
@endsection