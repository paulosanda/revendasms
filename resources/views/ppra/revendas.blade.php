@extends('ppra.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Revendas</div>
                <div class="card-body">

                    @foreach ($revendas as $e)
                    <div class="container">
                        <div class="row">
                            <h2><a href="revenda/{{$e->revendadados->id}} ">
                                @if(isset($e->revendadados->logo))
                                <img src="storage/{{$e->revendadados->logo}} " alt="Logo">
                                @endif
                                 {{$e->revendadados->nome}} </a></h2>
                        </div>
                        <div class="row">
                            CNAE: {{$e->revendadados->cnae}}
                        </div>
                        <div class="row">
                            Endereço: {{$e->revendadados->endereco}}
                        </div>
                        <div class="row">
                            CNPJ/CPF: {{$e->revendadados->documento}}
                        </div>
                        <div class="row">
                            Cidade:  {{$e->revendadados->cidade}} - UF: {{$e->revendadados->uf}}
                        </div>  
                        <div class="row">
                            <hr>
                        </div>
                     </div>
                     @endforeach
                     <div class="container">
                         <div class="row">
                     {{$revendas->links()}}
                         </div>
                     </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection