@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="container">
                        <div class="row">

                          <div class="col-md-12 mb-5">
                            <h2>Pedidos de recarga aguardando atendimento</h2>
                            <hr>
                            <div>

                            @foreach ($ped_aguardando as $pa) 
                            <p class="div-text">
                                <a href="{{ url('recarga_pedido/').'/'.$pa->id}}">
                                Pedido {{$pa->id}}
                                 - data: {{$pa['updated_at']->setTimezone(new DateTimeZone('America/Sao_Paulo'))}} 
                                 - quantidade: {{$pa->quantidade}}</a></p> 
                            @endforeach  

                            </div>
                          </div>
                          
                          <div class="col-md-12 mb-5">
                            <h2>Pedidos de recarga aguardando pagamento</h2>
                            <hr>
                            <div>
                            @foreach ($ped_boleto as $pb) 
                            <p class="div-text">
                                <a href="{{ url('recarga_pedido/').'/'.$pb->id}}">
                                    Pedido {{$pb->id}} - data: {{$pb['updated_at']->setTimezone(new DateTimeZone('America/Sao_Paulo'))}}
                                    - quantidade: {{number_format($pb->quantidade)}}
                                    
                                    - valor unitário: R$ {{number_format($pb->valor_unit, 2, ',', '.') }}</a>
                                </p>
                            @endforeach                            
                            </div>
                          </div>
                          
                          <div class="col-md-12 mb-5">
                            <h2>Pedidos de recarga atendidos a menos de 30 dias</h2>
                            <hr>
                            <div>
                            @foreach ($ped_finalizado as $pf)
                            <p class="div-text">
                                <a href="{{ url('recarga_pedido/').'/'.$pf->id}}">
                                Pedido {{$pf->id}} - 
                                data: {{$pf['updated_at']->setTimezone(new DateTimeZone('America/Sao_Paulo'))}} - 
                                quantidade: {{$pf->quantidade}}
                                - valor unitário: R$ {{number_format($pf->valor_unit, 2, ',', '.')}}</a>
                            </p>  
                            @endforeach 
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