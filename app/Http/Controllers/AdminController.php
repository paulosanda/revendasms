<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Disparo;
use App\MasterDisparo;

class AdminController extends Controller
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
        if(Auth::user()->is_admin == 1){
            $saldo_emp = Disparo::all()->sum('saldo');
            $saldo_geral = MasterDisparo::find(1);
            return view('admin.home', compact('saldo_emp','saldo_geral'));
        }
        //soma total de envios dos saldos das empresas clientes
        
        return view('home');
    }
    /**
     * Ajusta saldo master de disparos
     */
    public function dispAjSaldo(Request $request)
    {
        $existe = MasterDisparo::all()->count();
        if($existe < 1){
            //Não existe entrada, criar a primeira que será única
            $cria = new MasterDisparo();
            $cria->saldo_geral = $request->qtidade;
            $cria->save();
        }
        else{
            $carrega = MasterDisparo::find(1);
            //dd($request->qtidade);
            $novo_saldo = $carrega->saldo_geral + $request->qtidade;
            //dd($novo_saldo);
            $atualiza = MasterDisparo::find(1)->update(['saldo_geral' => $novo_saldo]);
        }
        $saldo_emp = Disparo::all()->sum('saldo');
        $saldo_geral = MasterDisparo::find(1);
        return view('admin.home', compact('saldo_emp','saldo_geral'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
