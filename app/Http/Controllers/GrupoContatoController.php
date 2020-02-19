<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Empresa;
use App\GrupoContato;
use App\ClienteGrupo;

class GrupoContatoController extends Controller
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
        $empresa = Empresa::find($empresa_id);
        $grupo_contato = GrupoContato::where('empresa_id',$empresa_id)->get();
        
        return view('grupo_contato_cria', compact('empresa','grupo_contato'));
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
        $regras = [
            'grupo'   => 'required',
        ];
        $mensagens = [
            'grupo.required' => 'é preciso digitar o grupo que pretende criar o campo veio vazio',
        ];
        $request->validate($regras, $mensagens);

        // verificando se grupo já existe
        $grupo = strtoupper($request->grupo);
        $empresa_id = Auth::user()->empresa_id;
        $grupo_existe = GrupoContato::where([
            'empresa_id'    => $empresa_id,
            'tipo_grupo'    => $grupo
        ])->count();
        //se existir retorna com erro - antes carregar dados
        if($grupo_existe > 0) {
            $empresa_id = Auth::user()->empresa_id;
            $empresa = Empresa::find($empresa_id);
            $grupo_contato = GrupoContato::where('empresa_id',$empresa_id)->get();
            return view('grupo_contato_cria', compact('empresa','grupo_contato','grupo_existe','grupo'));
        }
        //criando novo grupo para a empresa
        $novo_grupo = new GrupoContato();
        $novo_grupo->empresa_id = $empresa_id;
        $novo_grupo->tipo_grupo = $grupo;
        $novo_grupo->save();
        $grupo_id = $novo_grupo->id;
        $empresa = Empresa::find(Auth::user()->empresa_id);
        
        return view('carregalista',compact('grupo','grupo_id','empresa'));        
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
    public function update(Request $request)
    {
        $empresa_id = Auth::user()->empresa_id;
        $g_edita = strtoupper($request->grupo_tipo);
        $edita_grupo = GrupoContato::where('id',$request->id)->update([
            'tipo_grupo'    => $g_edita
        ]);
        return redirect('grupo_contato_cria');
    }

    public function apaga($id)
    {
        //ver se há contatos no grupo que vai ser apagado
        $clientesgrupo = ClienteGrupo::where('grupo_contato_id',$id)->count();
        $grupo_contato = GrupoContato::find($id);
        $empresa = Empresa::find(Auth::user()->empresa_id);
        return view('grupo_contato_confirma_apaga', compact('clientesgrupo','grupo_contato','id','empresa'));
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
