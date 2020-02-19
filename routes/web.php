<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index3');
});


Route::post('contato','FormController@enviar');


//início de pré cadastro
Route::get('cancela/{email}', 'PreCadController@cancela');
Route::get('bemvindo/{email}', 'PreCadController@bemvindo');
Route::post('codigoverifica', 'PreCadController@codigoverifica');
// para carregar cidades
Route::get('get-cidades/{estado_id}', 'PreCadController@getcidades')->name('get-cidades'); 
Route::post('precadEmpresa', 'PreCadController@precadempresa');
Route::post('precaduser','PreCadController@precaduser');

//cancelamento de pré cadastro
Route::get('precadcancela/{email}','PreCadController@precadcancela');
Route::post('precadcancelar','PreCadController@precadcancelado');

Auth::routes([
    'register' => false
]);



//Auth::routes();

//Rotas administrativas
Route::group(['middleware' => ['auth', 'check.admin']], function() {
//pré cadastro
Route::get('/precad','PreCadController@index');
Route::post('/precad','PreCadController@precad');
    //  Empresas
Route::get('/adminps','AdminController@index');
Route::get('/cad_empresa','EmpresasController@index');
Route::post('/cad_empresa','EmpresasController@store');
Route::get('/empresas','EmpresasController@list');
Route::get('/edit_empresa/{id}','EmpresasController@edit');
Route::post('/alt_empresa','EmpresasController@update');
//ver php do servidor
Route::get('phpinfo',function(){
    return view('admin.phpinfo');
});

//Rotas de adminstração para SMS
Route::get('recarga/{id}','AdminDisparoController@edit');
Route::post('recarga','AdminDisparoController@confirma');
Route::post('recarga_confirma','AdminDisparoController@update');
Route::get('recarga_pedidos','RecargaAtendimentoController@index');
Route::get('recarga_pedido/{id}','RecargaAtendimentoController@edit');
Route::post('recarga_atendimento','RecargaAtendimentoController@update');
Route::get('cancelar_pedido/{id}','RecargaAtendimentoController@destroy');
Route::get('cancelar_confirma/{id}','RecargaAtendimentoController@destroy_confirma');
Route::get('SmsErroAdmin','SmsErroAdminController@index');
Route::get('empresa_sms_erro/{id}','SmsErroAdminController@show');
Route::post('SmsErroAdmin','SmsErroAdminController@update');

//Ajusta saldo master de disparos  partir do qual todos são retirados
Route::post('adminps','AdminController@dispAjSaldo');

//Auditoria de erros no envio de sms
Route::get('/audita_arquivo','AuditaController@index');
Route::post('/audita_arquivo','AuditaController@audita');

//  Usuários
Route::get('/cad_user','UserController@index');
Route::post('/cad_user','UserController@store');
Route::get('/alt_user/{id}','UserController@edit');
Route::post('/alt_user','UserController@update');


});

//Rotas para o sistema
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/conta', 'ContaController@index')->name('conta');


Route::group(['middleware' => ['auth', 'check.status']], function() {
    // Precisa estar autenticado e o status deve ser ativo(1) conseguir acessar

    //listas de contato por carga
    Route::get('carregalista','CarregaListaController@index');
    Route::post('carregalista','CarregaListaController@carregalista');
    Route::post('detalhes_lista','CarregaListaController@detalhes');
    Route::post('apaga_lista','CarregaListaController@apaga');

    //administra contatos
    Route::get('lista_de_contatos','ContatosController@index'); //01/02/20 esta rota deve ser desativada
    Route::get('lista_grupo/{id}','ContatosController@listagrupo'); //01/02/20 esta rota deve ser desativada
    Route::get('admin_contatos','ContatosController@admin'); //4/2/2020 rota deve ficar obsoleta
    Route::get('contatos_del','ContatosController@delall');
    Route::get('admin_contatosV2','ContatosController@admin2');
    
    //administra clientes - individualmente
    Route::get('cliente_edita/{id}','ClienteController@edit');
    Route::post('cliente_edita','ClienteController@update');
    Route::get('cliente_apaga/{id}','ClienteController@destroy');
    Route::post('cliente_apaga','ClienteController@delete');
    


    //pedido de recarga
    Route::get('pedido_recarga','RecargaController@index');
    Route::post('pedido_recarga','RecargaController@store');
    //Route::post('pedido_recarga','RecargaController@store');
    //relatorios
    Route::get('relatorios_index','RelatorioImportacaoController@index');
    //SMS
    Route::get('sms_envia','EnvioController@index');
    Route::post('sms_envia_confirma','EnvioController@enviaconfirma');
    Route::post('sms_envia','EnvioController@envia');
    Route::get('sms_grupo','EnvioController@grupo');
    Route::post('sms_envia_grupo','EnvioController@grupo_form');
    Route::post('sms_grupo_confirma','EnvioController@grupo_confirma');
    Route::post('sms_grupo_enviar','EnvioController@grupo_enviar');

    //administra Grupos de Contato
    Route::get('grupo_contato_cria','GrupoContatoController@index');
    Route::post('grupo_contato_cria','GrupoContatoController@store');
    Route::post('grupo_contato_edita','GrupoContatoController@update');
    Route::get('grupo_contato_apaga/{id}','GrupoContatoController@apaga');
});





