<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Empresa;
use App\SmsLogErro;
use DB;
use App\SmsEstorno;
use App\Disparo;
use App\Http\Middleware\Psmid\InformaEstorno;

class SmsErroAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa = DB::table("empresas")
          ->select("empresas.*",
                    DB::raw("(SELECT empresa_id FROM sms_log_erros
                                WHERE empresa_id = empresas.id
                                GROUP BY sms_log_erros.empresa_id) as empresa"))
                    ->paginate(10);
        //dd($empresa);
        $geral =1;
        return view('admin.SmsErroAdmin',compact('empresa','geral'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa = DB::table("empresas")
          ->select("empresas.*",
                    DB::raw("(SELECT empresa_id FROM sms_log_erros
                                WHERE empresa_id = empresas.id
                                GROUP BY sms_log_erros.empresa_id) as empresa"))
                    ->paginate(10);
        
        $smserros = SmsLogErro::where('empresa_id',$id)->count();
        $emp = Empresa::find($id);
        return view('admin.SmsErroAdmin',compact('empresa','emp','smserros'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        //contando erros
        $erros = SmsLogErro::where('empresa_id',$request->empresa_id)->count();
        
        //deletando log de erros
        SmsLogErro::where('empresa_id',$request->empresa_id)->delete();

        // verificando usuário que está autorizando o estorno e gravando operação na tabela sms_estrono
        $user_id = Auth::user()->id;
        $estorno = new SmsEstorno();
        $estorno->user_id       = $user_id;
        $estorno->empresa_id    = $request->empresa_id;
        $estorno->credito       = $erros;
        $estorno->save();
        $estorno_id = $estorno->id;

        // realizando estorno devolvendo os créditos na tabela disparos
        $saldo = Disparo::where('empresa_id',$request->empresa_id)->first();
        $saldo_novo = $saldo->saldo + $erros;
        $creditar = Disparo::where('empresa_id',$request->empresa_id)->update([
            'saldo'     => $saldo_novo
        ]);
         
        // informando cliente que estorno foi realizado
        $sms = new InformaEstorno;
        $sms->informaestorno($request->empresa_id, $erros);
        
        //carregando dados para passaar para a view novamente.
        $empresa = DB::table("empresas")
          ->select("empresas.*",
                    DB::raw("(SELECT empresa_id FROM sms_log_erros
                                WHERE empresa_id = empresas.id
                                GROUP BY sms_log_erros.empresa_id) as empresa"))
                    ->paginate(10);
        $emp = Empresa::find($request->empresa_id);
        return view('admin.SmsErroAdmin',compact('empresa','emp','estorno_id','erros'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
