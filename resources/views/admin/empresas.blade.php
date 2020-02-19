@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Empresas</div>
                <div class="card-body">

                    @foreach ($empresa as $e)
                    <div class="container">
                        <div class="row">
                            <h2>
                                @if(isset($e->logo))
                                <img src="storage/{{$e->logo}} " alt="Logo">
                                @endif
                                 <a href="edit_empresa/{{$e->id}} ">{{$e->nome}} </a></h2>
                        </div>
                        <div class="row">
                            CNAE: {{$e->cnae}}
                        </div>
                        <div class="row">
                            Endereço: {{$e->endereco}}
                        </div>
                        <div class="row">
                            CNPJ/CPF: {{$e->doccumento}}
                        </div>
                        <div class="row">
                            Cidade:  {{$e->cidade}} - UF: {{$e->uf}}
                        </div>  
                        <div class="row">
                        @if($e->disparo->saldo < 1)
                        <p class="div-text bg-danger"><strong>Saldo de envios = {{$e->disparo->saldo}} </strong></p>
                        @endif
                        @if($e->disparo->saldo > 0)
                        <p class="div-text bg-ligth"><strong>Saldo de envios = {{$e->disparo->saldo}} </strong></p>
                        @endif
                        </div>
                        <div class="row">
                            <a class="btn btn-primary" href="recarga/{{$e->id}}" role="button">Fazer carga</a>
                            </div>
                        <div class="row">
                            <hr>
                        </div>
                        <div class="row">   
                            @if(isset($e->listUser))                     
                            @foreach ($e->listUser as $u)                          
                            <div class="col-md-4 mb-5">
                                <h5><a href="alt_user/{{$u->id}}">{{$u->name}}</a></h5>
                                Email: {{$u->email}} <br>
                                Celular: {{$u->telefone}}<br>
                                Status: {{$u->status}}<br>
                            </div>
                            @endforeach
                            @endif
                        </div>
                     </div>
                     @endforeach
                     <div class="container">
                         <div class="row">
                     {{$empresa->links()}}
                         </div>
                     </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection