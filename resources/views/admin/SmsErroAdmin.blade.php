@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(isset($geral))
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Empresas com Erro de envio</div>
                <div class="card-body">
                    @foreach ($empresa as $e)
                    @if(isset($e->empresa))
                    <div class="container">
                        <div class="row">
                            <h5><a href="{{ url('/empresa_sms_erro').'/'.$e->id}}">{{$e->nome}} </a></h5>
                        </div>
                     </div>
                     @endif
                     @endforeach
                     <div class="container">
                         <div class="row">
                     {{$empresa->links()}}
                         </div>
                     </div>
                </div>
            </div>
        </div>
        @endif
        @if(isset($emp))
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Empresas com Erro de envio</div>
                <div class="card-body">
                    @foreach ($empresa as $e)
                    @if(isset($e->empresa))
                    <div class="container">
                        <div class="row">
                            <h5><a href="{{ url('/empresa_sms_erro').'/'.$e->id}}">{{$e->nome}} </a></h5>
                        </div>
                     </div>
                     @endif
                     @endforeach
                     <div class="container">
                         <div class="row">
                     {{$empresa->links()}}
                         </div>
                     </div>
                </div>
            </div>
        </div>
        @if(!isset($estorno_id))
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Erros de envio para <strong> {{$emp->nome}} </strong> </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <p class="div-text">Tem {{$smserros}} envios para serem restituidos</p>
                        </div>
                        <form method="post" action="{{ url('/SmsErroAdmin')}}">
                            @csrf
                            <input type="hidden" name="empresa_id" value="{{$emp->id}}">
                            <input class="btn btn-warning" type="submit" value="Restituir envios">
                        </form>
                     </div>
                </div>
            </div>
        </div>
        @endif
        @if(isset($estorno_id))
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Estorno de erros de envio para <strong> {{$emp->nome}} realizado com sucesso </strong> </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <p class="div-text"> {{$erros}} envios para serem restituidos</p>
                        </div>
                     </div>
                </div>
            </div>
        </div>
        @endif
    @endif
    </div>
</div>
@endsection