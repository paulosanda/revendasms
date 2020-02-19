@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).on("input", "#mensagem", function() {
    var limite = 150;
    var informativo = "caracteres restantes.";
    var caracteresDigitados = $(this).val().length;
    var caracteresRestantes = limite - caracteresDigitados;

    if (caracteresRestantes <= 0) {
        var mensagem = $("textarea[name=mensagem]").val();
        $("textarea[name=mensagem]").val(mensagem.substr(0, limite));
        $(".caracteres").text("0 " + informativo);
    } else {
        $(".caracteres").text(caracteresRestantes + " " + informativo);
    }
});
</script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa[0]['logo']))
                    <img src="storage/{{$empresa[0]['logo']}} " alt="Logo">
                    @endif
                    @if(!isset($empresa[0]['logo']))
                    {{$empresa[0]['nome']}}
                    @endif
                    <span style="float:right">Enviar SMS</span>
                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 mb-5">
                                <p class="div-text">O total de sua lista de contatos é 
                                {{$clientes}}<br>
                                O saldo de envios é 
                                {{$empresa[0]['disparo']['saldo']}}
                                @if($clientes < $empresa[0]['disparo']['saldo'])
                                <form action="sms_envia_confirma" method="post">  
                                @csrf
                                <div class="form-group text-left">
                                    <label><b class="ls-label-text">Mensagem (máximo 150 caracteres)</b></p></label><br>
                                    <textarea name="mensagem" id="mensagem" cols="50" rows="5" maxlength="150"></textarea>
                                    <br><small class="caracteres"></small>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                                </form>
                                @endif
                                @if($clientes > $empresa[0]['disparo']['saldo'])
                                <p class="div-text">Você não tem saldo de envios o suficente, 
                                <a href="pedido_recarga"> solicite recarga.</a></p>
                                @endif
                            </div>
                            <div class="col-md-4 mb-5">
                                <div class="accordion" id="grupos">    
                                    @if($aniversarios > 0)
                                    <div class="card">
                                        <div class="card-header" id="aniversario">
                                            <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" 
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Aniversariantes do mês
                                            </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="aniversario" data-parent="#grupos">
                                            <div class="card-body">
                                            <p class="div-text">Há {{$aniversarios}} aniversariantes este mês.<br>
                                                Deseja enviar mensagem? </p>
                                                <form method="post" action="sms_envia_grupo">
                                                    <input type="hidden" name="tipo_grupo" id="grupo_id" value="aniversario_mes">
                                                    <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($grupos))
                                    @foreach ($grupos as $g)
                                    @if(isset($g['cliente_grupo'][0]))
                                    <div class="card">
                                        <div class="card-header" id="{{$g->tipo_grupo}}">
                                            <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" 
                                            data-target="#collapse{{$g->id}}" aria-expanded="true" aria-controls="collapse{{$g->id}}">
                                            {{$g->tipo_grupo}}
                                            </button>
                                            </h5>
                                        </div>
                                        <div id="collapse{{$g->id}}" class="collapse" aria-labelledby="{{$g->tipo_grupo}}" data-parent="#grupos">
                                            <div class="card-body">
                                            <p class="div-text">Deseja enviar mensagem para este o grupo {{$g->tipo_grupo}}.</p>
                                                <form method="post" action="sms_envia_grupo">
                                                    <input type="hidden" name="tipo_grupo" id="grupo_id" value="{{$g->id}}">
                                                    <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif    
                                    @endforeach
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