@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($empresa->logo))
                    <img src="storage/{{$empresa->logo}} " alt="Logo">
                    @endif
                    {{$empresa['nome']}}</div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            <h2>Você está apagando o grupo {{$grupo_contato->tipo_grupo}} </h2>
                            <hr>
                                @if($clientesgrupo > 0)
                                <p class="div-text">
                                    Este grupo tem {{$clientesgrupo}} contatos, 
                                    os contatos não serão apagados apenas desvinculados deste grupo.<br>
                                    Irão permanecer nos demais grupos caso estejam vinculados e/ou como contatos sem grupos.
                                </p>  
                                @endif                            
                            <p class="div-text">Deseja continuar?</p>

                                <a class="btn btn-danger" href="grupo_contato_apaga_confirma/{{$id}}" role="button">Sim desejo apagar</a>
          
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection