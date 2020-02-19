@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><img src="storage/{{$empresa->logo}} " alt="Logo"> 
                <span style="float:right">Relatorios</span>
                </div>

                <div class="card-body">
                    <div class="container">

                        <div class="row">
                            
                                <h3>Carregamento de contatos</h3>
                                @foreach ($relatorio_importacao as $ri)
                                <form method="post" action="detalhes_lista">
                                    @csrf
                                    <input type="hidden" name="data_hora" value="{{$ri->updated_at}}">
                                   <p class="div-text"><strong>Data: </strong>{{strftime("%d/%m/%Y", strtotime($ri->updated_at))}} |
                                        <strong>Hora: </strong> {{strftime("%H:%M", strtotime($ri->updated_at->setTimezone(new DateTimeZone('America/Sao_Paulo'))))}} |
                                        <strong>Repetidos: </strong>{{$ri->repetidos}} |
                                        <strong>Carregados:</strong> {{$ri->carregados}}
                                        <input class="btn btn-primary" type="submit" value="Detalhes"></p>
                                </form>
                                @endforeach    
                            </div> 
                            <div class="row">
                                <h3>Envios (ultimos 30 dias)</h3><br>
                            </div>
                            <div class="row">
                                @foreach ($relatorio_envio as $re)
                                   <p class="div-text"><strong>Data: </strong>{{strftime("%d/%m/%Y", strtotime($re->updated_at))}} |
                                        <strong>Hora: </strong> {{strftime("%H:%M", strtotime($re->updated_at->setTimezone(new DateTimeZone('America/Sao_Paulo'))))}} |
                                        <strong>Mensagem: </strong>{{$re->mensagem}} |
                                        <strong>Enviados:</strong> {{$re->total}}</p>
                                @endforeach    
                            </div> 
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection