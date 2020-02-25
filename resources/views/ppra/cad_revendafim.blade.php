@extends('ppra.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nova revenda cadastrada com sucesso!</div>
                <div class="card-body">
                    <div class="row">
                        <table class="table">
                            <tr>
                                <td>Logo: </td>
                                <td><img src="{{url('/')}}/storage/{{$empresa_dados->logo}}  " alt=""> </td>
                            </tr>
                            <tr>
                                <td>Empresa: </td>
                                <td>{{$empresa_dados->nome}} </td>
                            </tr>
                            <tr>
                                <td>Revenda ID: </td>
                                <td>{{$revenda_id}} </td>
                            </tr>
                            <tr>
                                <td>CNAE: </td>
                                <td>{{$empresa_dados->cnae}} </td>
                            </tr>
                            <tr>
                                <td>Documento: </td>
                                <td>{{$empresa_dados->documento}} </td>
                            </tr>
                            <tr>
                                <td>Cidade: </td>
                                <td>{{$empresa_dados->cidade}} </td>
                            </tr>
                            <tr>
                                <td>Estado: </td>
                                <td>{{$empresa_dados->uf}}</td>
                            </tr>
                            <tr>
                                <td>Usuário: </td>
                                <td>{{$user->name}} </td>
                            </tr>
                            <tr>
                                <td>E-mail: </td>
                                <td>{{$user->email}} </td>
                            </tr>
                            <tr>
                                <td>Tem status de admin? </td>
                                <td>
                                    @if($user->is_admin == 1)
                                    Sim - Ok
                                    @endif
                                    @if($user->is_admin == 0)
                                    Não - verifique isto
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Status inicial 3: </td>
                                <td>{{$user->status}} </td>
                            </tr>
                            <tr>
                                <td>Telefone: </td>
                                <td>{{$user->telefone}} </td>
                            </tr>
                        </table>
                    </div>                  
                </div>
            </div>    
        </div>
    </div>
</div>
@endsection