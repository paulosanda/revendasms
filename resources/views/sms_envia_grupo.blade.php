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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa[0]['logo']))
                    <img src="storage/{{$empresa[0]['logo']}} " alt="Logo">
                    @endif
                    @if(!isset($empresa[0]['logo']))
                    {{$empresa[0]['nome']}}
                    @endif
                    <span style="float:right">Enviar SMS (
                        @if(isset($aniversarios_mes))
                        aniversariantes do mês
                        @endif
                        @if(isset($aniversarios_hoje))
                        aniversariantes de hoje
                        @endif
                        @if(isset($grupo_nome))
                        {{$grupo_nome->tipo_grupo }}
                        @endif

                    )</span>
                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 mb-5">
                                <p class="div-text">O total de sua contatos
                                @if(isset($aniversarios_mes))   
                                aniversariando este mês
                                @endif
                                @if(isset($aniversarios_hoje))   
                                aniversariando hoje
                                @endif
                                @if(isset($grupo_nome))
                                 para o grupo {{$grupo_nome->tipo_grupo }}
                                @endif
                                    é 
                                {{$lista}}<br>
                                O saldo de envios é 
                                {{$empresa[0]['disparo']['saldo']}}
                                @if($lista < $empresa[0]['disparo']['saldo'])
                                <form action="sms_grupo_confirma" method="post">  
                                @csrf
                                <input type="hidden" name="grupo_id" value="{{$grupo_id}}">
                                @if(isset($aniversarios_mes))   
                                <input type="hidden" name="grupo_tipo" value="aniversariando do mês">
                                @endif
                                @if(isset($aniversarios_hoje))   
                                <input type="hidden" name="grupo_tipo" value="aniversariando hoje">
                                @endif
                                @if(isset($grupo_nome))
                                <input type="hidden" name="grupo_tipo" value="{{$grupo_nome->tipo_grupo }}">
                                @endif
                                <div class="form-group text-left">
                                    <label><b class="ls-label-text">Mensagem (máximo 150 caracteres)</b></p></label><br>
                                    <textarea name="mensagem" id="mensagem" cols="50" rows="5" maxlength="150"></textarea>
                                    <br><small class="caracteres"></small>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                                </form>
                                @endif
                                @if($lista > $empresa[0]['disparo']['saldo'])
                                <p class="div-text">Você não tem saldo de envios o suficente, 
                                <a href="pedido_recarga"> solicite recarga.</a></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection