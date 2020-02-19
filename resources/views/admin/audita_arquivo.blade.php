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
                            <h2>Auditoria de Erros no envio de SMS</h2>
                            <hr>
                            <form action="{{url('/')}}/audita_arquivo" method="post" enctype="multipart/form-data">  
                                @csrf
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="arquivo" name="arquivo" required>
                                <label class="custom-file-label" for="arquivo">Selecione o arquivo</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                          </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection