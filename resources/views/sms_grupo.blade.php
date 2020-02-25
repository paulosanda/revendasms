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
                    <span style="float:right">Enviar SMS (Para grupos)</span>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="card">
                            <p class="div-text">Nesta tela você pode enviar mensagens para seus grupos; caso existam.<br>
                            Você não precisa criar grupos como "aniversariantes do mês" ou "aniversariantes de hoje" basta
                            ter a data de nascimento de  seus contatos no cadastro que este grupo será criado automaticamente.<br>
                            Outros grupos que você criar somente serão listados a partir do momento que houver contatos
                            cadastrados neles.</p>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-5">
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
                                                    @csrf
                                                    <input type="hidden" name="grupo_id" id="grupo_id" value="aniversario_mes">
                                                    <button type="submit" class="btn btn-sm btn-primary">Sim</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($aniversarios_hoje > 0)
                                    <div class="card">
                                        <div class="card-header" id="aniversario_hoje">
                                            <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" 
                                            data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                                            Aniversariantes de hoje {{date('d/m/Y')}}
                                            </button>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="aniversario_hoje" data-parent="#grupos">
                                            <div class="card-body">
                                                <p class="div-text">Há {{$aniversarios_hoje}} aniversariantes hoje.<br>
                                                Deseja enviar mensagem? </p>
                                                <form method="post" action="sms_envia_grupo">
                                                    @csrf
                                                    <input type="hidden" name="grupo_id" id="grupo_id" value="aniversario_hoje">
                                                    <button type="submit" class="btn btn-sm btn-primary">Sim</button>
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
                                                    @csrf
                                                    <input type="hidden" name="grupo_id" id="grupo_id" value="{{$g->id}}">
                                                    <button type="submit" class="btn btn-sm btn-primary">Sim</button>
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