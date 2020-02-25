@extends('ppra.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Revenda</div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <h2><a href="{{url('/')}}/edit_revenda/{{$empresa->id}}">
                                @if(isset($empresa->logo))
                                <img src="{{url('/')}}/storage/{{$empresa->logo}} " alt="Logo">
                                @endif
                                {{$empresa->nome}}</h2></a>
                        </div>
                        <div class="row">
                            CNAE: {{$empresa->cnae}}
                        </div>
                        <div class="row">
                            Endereço: {{$empresa->endereco}}
                        </div>
                        <div class="row">
                            CNPJ/CPF: {{$empresa->documento}}
                        </div>
                        <div class="row">
                            Cidade:  {{$empresa->cidade}} - UF: {{$empresa->uf}}
                        </div>  
                        <div class="row">
                        @if($saldo_master->saldo_geral < 1)
                        <p class="div-text bg-danger"><strong>Saldo Master em envios = {{$saldo_master->saldo_geral}} </strong></p>
                        @endif
                        @if($saldo_master->saldo_geral > 0)
                        <p class="div-text bg-ligth"><strong>Saldo de envios = {{$saldo_master->saldo_geral}} </strong></p>
                        @endif
                        </div>
                        <div class="row">
                            <strong>Carregar saldo geral de envios da revenda</strong>
                        </div>
                        <div class="row">
                            <form method="POST" action="{{url('/')}}/carregamaster">
                                @csrf
                                <input type="hidden" name="revenda_id" value="{{$revenda_id}}">
                                <input type="hidden" name="empresa_id" value="{{$empresa->id}} ">
                                <input type="hidden" name="saldoatual" id="saldoatual" value="{{$saldo_master->saldo_geral}}">
                                <div class="form-check form-check-inline" id="operacaomais">
                                    <input class="form-check-input" type="radio" name="operacao" id="opmais" value="mais">
                                    <label class="form-check-label" for="opmais">Adiciona</label>
                                  </div>
                                  <div class="form-check form-check-inline" id="operacaomenos">
                                    <input class="form-check-input" type="radio" name="operacao" id="opmenos" value="menos">
                                    <label class="form-check-label" for="opmenos">Subtrai</label>
                                  </div>
                            <div class="form-group" id="recarrega">
                                <label for="recarga">Recarga</label>
                                <input type="number" class="form-control" name="recarga" id="recarga">
                            </div>
                            <div class="form-group" id="botao">
                                <input type="button" class="btn btn-primary" value="Calcular" onclick="resultado()">
                            </div>
                            </form>
                        </div>
                        <div class="row">
                            <hr>
                            <H4>Usuários</H4>
                            <hr>
                            <table class="table table-striped">
                                <thead>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Status</th>
                                    <th>Celular</th>
                                </thead>
                                @foreach ($empresa->listUser as $user)
                                    <tr>
                                        <td><a href="{{url('/')}}/revenda_user_alt/{{$user->id}}">{{$user->name}}</a> </td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @if($user->status == 1)
                                            Ativo
                                            @endif
                                            @if($user->status == 0)
                                            Bloqueado
                                            @endif
                                            @if($user->status ==2 || $user->status == 3 )
                                            Aguardando aceite dos termos de uso
                                            @endif
                                        </td>
                                        <td>{{$user->telefone}}</td>
                                    </tr>
                                @endforeach
                            </table>
                            
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection