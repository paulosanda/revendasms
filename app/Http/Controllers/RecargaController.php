<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Empresa;
use App\Recarga;

/**
 * Os status de pedidos de recarga são:
 * Aguardando atendimento
 * Boleto enviado
 * Finalizado
 */

class RecargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa_id = Auth::user()->empresa_id;
        $empresa = Empresa::find($empresa_id);
        return view('pedido_recarga', compact('empresa'));
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
        $user_id = Auth::user()->id;
        $empresa_id = Auth::user()->empresa_id;
        $quantidade = $request->recarga;
        $pedido = new Recarga();
        $pedido->user_id = $user_id;
        $pedido->quantidade = $quantidade;
        $pedido->status = 'Aguardando atendimento';
        $pedido->save();
        $empresa = Empresa::find($empresa_id);

        return view('pedido_realizado', compact('quantidade','empresa'));

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
