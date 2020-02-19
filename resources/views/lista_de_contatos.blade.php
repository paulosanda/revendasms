@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa->logo))
                    <img src="storage/{{$empresa->logo}} " alt="Logo">
                    @endif
                    @if(!isset($empresa->logo))
                    {{$empresa['nome']}}
                    @endif
                    @if(isset($grupo) == FALSE)
                    <span style="float:right">Lista Geral de Contatos</span>
                    @endif
                    
                </div>
                <div class="card-body">
                    <div class="accordion" id="listageral">
                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                TODOS CONTATOS
                              </button>
                            </h2>
                          </div>
                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#listageral">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <table class="table">
                                            <thead>
                                                <th>Nome</th>
                                                <th>Nascimento</th>
                                                <th>E-mail</th>
                                                <th>Celular</th>
                                                <th>Sexo</th>
                                                <th></th>
                                            </thead>
                                           
                                            <tbody>
                                                @foreach ($lista as $li)
                                                <tr> 
                                                    <td>{{$li->nome}}</td>
                                                    <td> {{$li->nascimento}}</td>
                                                    <td>{{$li->email}}</td>
                                                    <td>{{$li->telefone}}</td>
                                                    <td>{{$li->sexo}}</td>
                                                    <td><a href="cliente_edita/{{$li->id}}" class="badge badge-warning">editar</a>
                                                        
                                                    </td>
                                                </tr>
                                                </form>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="card-footer">{{$lista->links()}}</div>
                                    </div>
                                   
                                </div>
                            </div>
                          </div>
                        </div>
<!-- listagem de grupos se houver ------------> 
@if(isset($listagrupos))

    
                        <div class="card">
                          <div class="card-header" id="Grupos">
                            <h2 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" 
                              data-target="#collapseGrupos" aria-expanded="false" aria-controls="collapseGrupos">
                                GRUPOS
                              </button> 
                            </h2>
                          </div>
                          <div id="collapseGrupos" class="collapse" aria-labelledby="Grupos" data-parent="#listageral">
                            <div class="card-body">
                              @foreach ($listagrupos as $lg) <?php $ponteiro = 0 ?>
                              @if(isset($lg['cliente'][$ponteiro]['id']))
                              <p><a href="{{url('/')}}/lista_grupo/{{$lg->id}}">{{$lg->tipo_grupo}} </a></p>  


                              @endif     
                              <?php $ponteiro++ ?>                   
                              @endforeach                        

                            </div>
                          </div>
                        </div>
                        @endif
 <!-- fim listagem de grupos se houver ------------>
                      </div>
                </div> 
            </div> 
        </div>
    </div>
</div>
@endsection