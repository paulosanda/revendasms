<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Disparo;
use App\Cliente;
use Auth;
use App\Empresa;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //carrega id da empresa do usuário
        $empresa_id = Auth::user()->empresa_id;
        $saldo = Disparo::where('empresa_id',$empresa_id)->first();
        $cli_num = Cliente::where('empresa_id',$empresa_id)->count();
        $empresa = Empresa::find($empresa_id);
        
        return view('home', compact('saldo','cli_num','empresa'));
    }
}
