<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Empresa;
use Auth;
use App\GrupoContato;
use App\ClienteGrupo;
use App\Http\Middleware\Psmid\DeletaContato;
use App\Http\Middleware\Psmid\Sms;

class ContatosController extends Controller
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
        $empresa_id = Auth::user()->empresa_id;
        $lista = Cliente::where('empresa_id',$empresa_id)
        ->orderBy('nome')
        ->paginate(25);

        //carregando grupos
        $listagrupos = GrupoContato::with('cliente')
        ->where('empresa_id',$empresa_id)->get();
        

        $empresa = Empresa::find($empresa_id);
        return view('lista_de_contatos', compact('lista','empresa','listagrupos'));
    }

    public function admin() 
    {
        $empresa_id = Auth::user()->empresa_id;
        $clientes = Cliente::where('empresa_id',$empresa_id)
        ->count();
        $grupos = GrupoContato::all();
        $empresa = Empresa::find($empresa_id);
        return view('admin_contatos', compact('clientes','grupos','empresa'));

    }

    public function admin2() //não está ativo
    {
        $empresa_id = Auth::user()->empresa_id;
        $clientes = Cliente::where('empresa_id',$empresa_id)
        ->count();
        $lista = Cliente::where('empresa_id',$empresa_id)->orderBy('nome')->paginate(25);
        $empresa = Empresa::find($empresa_id);
        $grupos = GrupoContato::where('empresa_id',$empresa_id)->get();
        
        return view('admin_contatosV2', compact('clientes','empresa','lista','grupos'));

    }


    public function delall() // apaga todos os contatos em clientes e em cliente_grupos
    {  
        $empresa_id = Auth::user()->empresa_id;
        $deleta = new DeletaContato;
        $deleta->setEmpresaId($empresa_id);
        $deleta->deletacontatoall();
        $del = 1;
        $empresa = Empresa::find($empresa_id);
        return view('admin_contatos', compact('empresa','del'));

    }

    public function listagrupo($id)
    {
        $empresa_id = Auth::user()->empresa_id;
        $listagrupo = GrupoContato::with('cliente')
        ->where([
            'empresa_id'    =>$empresa_id,
            'id'            =>$id
            ])->paginate(25);
        //dd($listagrupo);
        $grupo = $id;
        $empresa = Empresa::find($empresa_id);
        //dd($empresa);
        return view('lista_de_contatos_grupo', compact('grupo','empresa','listagrupo'));
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
