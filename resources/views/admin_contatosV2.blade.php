@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                @if(isset($empresa->logo))
                <img src="{{url('/')}}/storage/{{$empresa->logo}} " alt="{{$empresa->nome}} ">
                @endif         
                @if(!isset($empresa->logo))
                {{$empresa->nome}}
                @endif             
            </div>
            <div class="card-body" id="bcad">
                <div class="container">
                    <div class="row">
                        <h3>Grupos</h3>
                    </div>
                    <div class="row">
                        <strong><a href="#">TODOS</a></strong> &nbsp; | &nbsp;
                        @foreach ($grupos as $g)
                        <strong><a href="#">{{$g->tipo_grupo}} </a></strong>  &nbsp; | &nbsp;
                        @endforeach
                    </div>
                    

                    <div class="row">
                        <h3>Geral - {{$clientes}} contatos (todos os contatos)</h3>
                        <hr> 
                    </div>
                    <div class="row" id="todos">
                        <table class="table">
                        <thead>
                        <th>Nome</th>
                        <th>Nascimento</th>
                        <th>E-mail</th>
                        <th>Celular</th>
                        <th></th>
                        </thead>     
                        <tbody>
                        
                        @foreach ($lista as $li)
                        <tr> 
                        <td>{{$li->nome}}</td>
                        <td>{{$li->nascimento}}</td>
                        <td>{{$li->email}}</td>
                        <td>{{$li->telefone}}</td>
                        <td><a href="cliente_edita/{{$li->id}}" class="badge badge-warning">editar</a>             
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="card-footer">{{$lista->links()}}</div> 
        </div>     
    </div>
</div>
 
@endsection