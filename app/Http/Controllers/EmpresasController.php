<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Empresa;
use App\Disparo;
use App\Http\Middleware\Psmid\CadEmpresa;
use App\Estado;

class EmpresasController extends Controller
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
            $estado = Estado::all();
            return view('admin.cad_empresa', compact('estado'));
        }
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
        $cadempresa = new CadEmpresa;
        $cadempresa->cadempresa($request);
        return redirect('/empresas');
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
        $empresa = Empresa::find($id);
        return view('admin.edit_empresa', compact('empresa'));
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
        if(isset($request->arquivo)){
            // apagando arquivo logo se novo for carregado
            $patch = $request->file('arquivo')->store('logos','public');
            // gravando novo logo
            $patch = $request->file('arquivo')->store('logos','public');
        }
        $edit = Empresa::where('id',$request->id)->update([
            'nome'      =>  $request->name,
            'cnae'      =>  $request->cnae,
            'endereco'  =>  $request->endereco,
            'cidade'    =>  $request->cidade,
            'uf'        =>  $request->uf,
            'documento' =>  $request->documento
            
        ]);        
        if(isset($patch)){
            $edit = Empresa::where('id',$request->id)->update(['logo'=> $patch]);
        } 
        return redirect('empresas');
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

    
    public function list()
    {
        $empresa = Empresa::with('listUser','disparo')->orderBy('nome')->paginate(10);
        //dd($empresa);
        return view('admin.empresas', compact('empresa'));

    }
}
