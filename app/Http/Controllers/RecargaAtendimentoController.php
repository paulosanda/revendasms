<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recarga;
use App\User;
use App\Empresa;
use App\Disparo;
use App\MasterDisparo;
/**
 * Os status de pedidos de recarga são:
 * Aguardando atendimento
 * Boleto enviado
 * Finalizado
 * Cancelado
 */

class RecargaAtendimentoController extends Controller
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
        $ped_aguardando = Recarga::where('status','Aguardando atendimento')->get();
        $ped_boleto = Recarga::where('status','Boleto enviado')->get();
        $timestamp = strtotime("-30 days");
        $data = date('Y-m-d H:i:s', $timestamp);
        $ped_finalizado = Recarga::where([
            ['status',       '=', 'Finalizado'],
            ['updated_at',   '>=', $data]
        ])->orderBy('updated_at','DESC')->get();
        
        return view('admin.recarga_pedidos', compact('ped_aguardando','ped_boleto','ped_finalizado'));
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
        $pedido = Recarga::where('id',$id)->get();
        //dd($pedido);
        $user = User::where('id',$pedido[0]->user_id)->get();
        //dd($user);
        $empresa = Empresa::where('id',$user[0]['empresa_id'])->get();
        //dd($empresa);
        $valor = $pedido[0]['quantidade'] * $pedido[0]['valor_unit'];
        return view('admin.recarga_pedido', compact('pedido','user','empresa','valor'));
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
        if($request->status == 'Boleto enviado'){
            $v_unit = str_replace(',','.',$request->v_unit);
            $pedido = Recarga::where('id',$request->pedido_id)->update([
                'valor_unit'    => $v_unit,
                'status'        => $request->status
            ]);

        }
        
        if($request->status == 'Finalizado'){
            $v_unit = str_replace(',','.',$request->v_unit);
            $pedido = Recarga::where('id',$request->pedido_id)->update([
                'valor_unit'    => $v_unit,
                'status'        => $request->status
            ]); 
            //acrescentando envios na tabela disparos
            $disparos= Disparo::where('empresa_id',$request->empresa_id)->get();
            $novo_saldo = $disparos[0]['saldo'] + $request->quantidade;
            $credita = Disparo::where('empresa_id',$request->empresa_id)->update([
                'saldo'   => $novo_saldo
            ]);
            //retirando de saldo_geral em master_disparos
            //lendo saldo_geral
            $s_geral = MasterDisparo::find(1);
            $novo_s_geral = $s_geral->saldo_geral - $request->quantidade;
            //atualizando
            MasterDisparo::find(1)->update(['saldo_geral' => $novo_s_geral]);
        }

        $ped_aguardando = Recarga::where('status','Aguardando atendimento')->get();
        $ped_boleto = Recarga::where('status','Boleto enviado')->get();
        $timestamp = strtotime("-30 days");
        $data = date('Y-m-d H:i:s', $timestamp);
        $ped_finalizado = Recarga::where([
            ['status',       '=', 'Finalizado'],
            ['updated_at',   '>=', $data]
        ])->get();
        $pedido = Recarga::where('id',$request->pedido_id)->get();
        //dd($pedido);
        $valor = $pedido[0]['quantidade'] * $pedido[0]['valor_unit'];
        
        return view('admin.recarga_pedidos', compact('ped_aguardando','ped_boleto','ped_finalizado','valor'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedido = Recarga::find($id);
        $user = User::find($pedido['user_id']);
        $empresa = Empresa::find($user['empresa_id']);
        return view('admin.cancelar_pedido', compact('pedido','user','empresa'));
    }
    public function destroy_confirma($id) {
        //cancelando pedido
        $cancela = Recarga::where('id',$id)->update([
            'status'    => 'Cancelado'
        ]);

        $ped_aguardando = Recarga::where('status','Aguardando atendimento')->get();
        $ped_boleto = Recarga::where('status','Boleto enviado')->get();
        $timestamp = strtotime("-30 days");
        $data = date('Y-m-d H:i:s', $timestamp);
        $ped_finalizado = Recarga::where([
            ['status',       '=', 'Finalizado'],
            ['updated_at',   '>=', $data]
        ])->get();
        $pedido = Recarga::where('id',$id)->get();
        //dd($pedido);
        $valor = $pedido[0]['quantidade'] * $pedido[0]['valor_unit'];
        
        return view('admin.recarga_pedidos', compact('ped_aguardando','ped_boleto','ped_finalizado','valor'));
    }
}
