<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\Disparo;
use App\MasterDisparo;
use App\Http\Middleware\Psmid\DisparosOp;

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
       $empresa_id  = $request->id;
       $novo_saldo_disparo = $request->qtidade;
       $recarga = $request->recarga;      
       $alt_saldo = new DisparosOp;
       $alt_saldo->alteradisparos($empresa_id, $recarga, $novo_saldo_disparo) ;
       $empresa = Empresa::with('disparo')->where('id',$request->id)->get(); 
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
