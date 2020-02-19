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
                    <span style="float:right">Pedido de envios</span>
                </div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">
                          <div class="col-md-12 mb-5">
                            <h2>Solicitar recarga</h2>
                            <hr>
                            <form action="pedido_recarga" method="post">  
                                @csrf
                            <div class="form-group text-left">
                                <label><b class="ls-label-text">Quantidade de envios</b></label><br>
                                <input type="number" id="recarga" name="recarga">
                            </div>
                            <button type="submit" class="btn btn-primary">Solicitar</button>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection