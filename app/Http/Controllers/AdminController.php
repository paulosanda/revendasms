<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Disparo;
use App\MasterDisparo;
use App\Http\Middleware\Psmid\Revendaid;
use App\Empresa;

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
        /**
         * função para interface administrativa geral e de revenda
         * O bloqueio é feito na rota pelo middleware CheckAdmin 
         * e também na condição abaixo, porém é preciso carregar a sessão
         * se a EMPRESA_ID for 1 serão habilitadas as funções administrativas gerais
         * Senão apenas as funções administrativas de revenda
         * 
         */
        if(Auth::user()->is_admin == 1){
            $revenda = new Revendaid;
            $revenda_id = $revenda->revendaid(Auth::user()->empresa_id);
            $saldo_emp = Disparo::where('revenda_id', $revenda_id)->sum('saldo');
            $saldo_geral = MasterDisparo::where('revenda_id',$revenda_id)->first();
            //aqui os dados da empresa estão sendo tratados como dados da revenda pois trata-se de interface de revenda
            $revenda = Empresa::where('id',Auth::user()->empresa_id)->first();
            return view('admin.home', compact('saldo_emp','saldo_geral','revenda'));
        }
        //soma total de envios dos saldos das empresas clientes
        
        return view('home');
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
