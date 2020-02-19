@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> @if(isset($empresa->logo))
                    <img src="storage/{{$empresa->logo}} " alt="Logo">
                    @endif
                    {{$empresa['nome']}}</div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <h2>Relatório de listas carregadas</h2>
                                <hr>
                            </div>
                         
                            <div class="card">
                                <p class="div-text">Dia - hora | Foram carregados XX contatos | xx não foram carregados pois estavam repetidos </p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection