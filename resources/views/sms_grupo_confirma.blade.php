@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa[0]['logo']))
                    <img src="storage/{{$empresa[0]['logo']}} " alt="Logo">
                    @endif
                    @if(!isset($empresa[0]['logo']))
                    {{$empresa[0]['nome']}}
                    @endif
                    <span style="float:right">Confirmar SMS para Grupo</span>
                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            <h2>Confirmar</h2>
                            <hr>
                            <p class="div-text">Verifique a mensagem está enviando para {{$grupo}}.<br>
                            @if($q_caracter > 150)
                            <p class="div-text">Seu texto tem {{$q_caracter}} ultrapassando  150 caracteres, 
                                retorne e edite por favor.
                            </p>
                            @endif
                            <p class="div-text">{{$mensagem}} </p>
                                <form action="sms_grupo_enviar" method="post">  
                                @csrf
                            <div class="form-group text-left">
                                <input type="hidden" name="mensagem" value="{{$mensagem}}">
                                <input type="hidden" name="grupo_id" value="{{$grupo_id}}">
                            </div>
                           
                            <input type="button" class="btn btn-warning" value="Retorna" onclick="history.back()">
                            @if($q_caracter < 151)
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            @endif
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