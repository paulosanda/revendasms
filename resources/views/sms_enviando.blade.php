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
                    @if(!isset($empresa->logo))
                    {{$empresa['nome']}}
                    @endif
                    <span style="float:right">SMS</span>
                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            <h2>Enviando SMS</h2>
                            <hr>
                            <p class="div-text">As mensagens estão sendo enviadas em breve poderá ver o relatório em Conta/Relatórios.<br>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection