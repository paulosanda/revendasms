@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa->logo))
                    <img src="{{url('/')}}/storage/{{$empresa->logo}} " alt="{{$empresa->nome}} "></div>
                    @endif
                    @if(!isset($empresa->logo))
                    {{$empresa->nome}}
                    @endif
                <div class="card-body" id="bcad">
                    <div class="container">
                        <div class="row">
                                
                                <h3>Apagar Contatos</h3>
                                <hr>
                            
                        </div>
                        @if(isset($clientes))
                        <div class="row" id="deldiv">
                            <p class="div-text">Você tem {{$clientes}} contatos cadastrados, deseja apagar todos os contatos? </p>
                            <p><a href="#" id="delall-confirma" class="btn alert-danger" onclick="del1()" >Apagar</a></p>
                            
                        </div>
                        @endif
                        @if(isset($del))
                        <div class="row">
                            <p>Não existem mais contatos cadastrados.
                                <br> Para fazer envios de mensagem você deverá cadastrar novamente seus contatos.
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection