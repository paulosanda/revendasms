<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Auth;
use App\Empresa;
use App\ClienteGrupo;

class ClienteController extends Controller
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
        $empresa_id = Auth::user()->empresa_id;
        $cliente = Cliente::find($id);
        $empresa = Empresa::find($empresa_id);
        return view('cliente_edita',compact('empresa','cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $edita_cliente = Cliente::where('id',$request->cliente_id)->update([
            'nome'          => $request->nome,
            'nascimento'    => $request->nascimento,
            'email'         => $request->email,
            'telefone'      => $request->telefone,
            'sexo'          => $request->sexo
        ]);
        return redirect('lista_de_contatos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa_id = Auth::user()->empresa_id;
        $cliente = Cliente::find($id);
        $empresa = Empresa::find($empresa_id);
        return view('cliente_apaga', compact('empresa','cliente'));
    }
    public function delete(Request $request) 
    {
        $empresa_id = Auth::user()->empresa_id;
        $empresa = Empresa::find($empresa_id);
        //verificando se contato está em algum grupo de contato
        $grupo = ClienteGrupo::where('cliente_id',$request->cliente_id)->count();
        if($grupo > 0) {
            ClienteGrupo::where('cliente_id',$request->cliente_id)->delete();
        }
        Cliente::where('id',$request->cliente_id)->delete();
        //verificando se contato está em algum grupo de contato
        $delete = 1;
        return view('cliente_apaga', compact('empresa','delete'));
    }
}
