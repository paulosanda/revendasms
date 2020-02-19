<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Disparo;
use App\MasterDisparo;

class AdminDisparoController extends Controller
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
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresa = Empresa::with('disparo')->where('id',$id)->get();
        //dd($empresa);
        return view('admin.disparo_carrega', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirma(Request $request)
    {
       //fazendo recarga
        $saldo = Disparo::where('empresa_id',$request->id)->get();
        $recarga = $request->recarga;
        $qtidade = $saldo[0]['saldo'] + $request->recarga;
        $empresa = Empresa::with('disparo')->find($request->id);
        //dd($empresa);
        return view('admin.disparo_carrega_confirma', compact('qtidade','empresa','recarga'));
        
    
       
    }

    public function update(Request $request)
    {
        //fazendo recarga
        $conta = Disparo::where('empresa_id',$request->id)->update([
           'saldo'  => $request->qtidade
       ]);
       $empresa = Empresa::with('disparo')->where('id',$request->id)->get();

       //retira saldo_geral em master_disparos
       //caregando saldo_geral
       $saldo_geral = MasterDisparo::find(1);
       $novo_saldo = $saldo_geral->saldo_geral - $request->recarga;
      
       
       //atualiza saldo_geral
       MasterDisparo::find(1)->update(['saldo_geral' => $novo_saldo]);

       return view('admin.carga_realizada', compact('empresa'));
       
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
