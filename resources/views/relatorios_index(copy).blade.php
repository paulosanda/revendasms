@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <img src="storage/{{$empresa->logo}} " alt="Logo">
          <span style="float:right">Relatorios</span>
        </div>
        <div class="card-body">
          <div class="accordion" id="grava">
            <div class="card">
              <div class="card-header" id="relatorios">
                <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" 
                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Gravação de Contatos</button></h2>
              </div>
              <div id="collapseOne" class="collapse" aria-labelledby="grava" data-parent="#relatorios">
                <div class="card-body">
                  @foreach ($relatorio_importacao as $ri)
                  <form method="post" action="detalhes_lista">
                  @csrf
                  <input type="hidden" name="carga_id" value="{{$ri->id}}">
                  <p class="div-text"><strong>Data: </strong>{{strftime("%d/%m/%Y", strtotime($ri->created_at))}} |
                  <strong>Hora: </strong> {{strftime("%H:%M", strtotime($ri->created_at->setTimezone(new DateTimeZone('America/Sao_Paulo'))))}} |
                  <strong>Repetidos: </strong>{{$ri->telefone_repetido}} |
                  <strong>Carregados:</strong> {{$ri->	telefone_carregado}}
                  <input class="btn btn-primary" type="submit" value="Detalhes"></p>
                  </form>
                  @endforeach    
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="envios">
                <h2 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" 
                data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Envios (últimos 30 dias)
                </button>
                </h2>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#relatorios">
                <div class="card-body">
                @foreach ($relatorio_envio as $re)
                <p class="div-text"><strong>Data: </strong>{{strftime("%d/%m/%Y", strtotime($re->updated_at))}} |
                <strong>Hora: </strong> {{strftime("%H:%M", strtotime($re->updated_at->setTimezone(new DateTimeZone('America/Sao_Paulo'))))}} |
                <strong>Mensagem: </strong>{{$re->mensagem}} |
                <strong>Enviados:</strong> {{$re->total}}</p>
                @endforeach 
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" 
                data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Logs de erro de Envio
                </button>
                </h2>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#relatorios">
                <div class="card-body">
                  @if($log_erro > 0)
                  <p class="div-text">Sua conta tem {{$log_erro}} disparos que falharam.</p>
                  <p class="div-text">Não se preocupe, este erro está sendo auditado e sendo 
                  confirmado o erro eles serão creditados de volta em seu saldo de envios</p>
                  @endif
                  @if($log_erro < 1)
                  <p class="div-text">Não há falhas de envio detectadas em sua conta.</p> 
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection