<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
// o modelo  abaixo está descontinuado pode ser apagado 
//use App\ImportaRelatorio;
use App\CargaContatoRelatorio;
use App\Empresa;
use App\SmsRelatorio;
use App\GrupoContato;
use App\SmsLogErro;


class RelatorioImportacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        /**
         * Esta função originalmente iria buscar apenas os relatorios de 
         * importação de contatos, porém também está sendo usada para 
         * os relatórios de envio de SMS
         */
        /** 
         * Função descontinuada pode ser apagada
         * 
         * $relatorio_importacao = ImportaRelatorio::where('empresa_id',$empresa_id)
         * ->orderBy('id','DESC')->limit(1)->get();
         */
        $empresa_id = Auth::user()->empresa_id; 
        //carrega de carga_contato_relatorios
        $relatorio_importacao = CargaContatoRelatorio::where('empresa_id', $empresa_id)
        ->orderBy('id','desc')->get();
        //dd($relatorio_importacao);
        $empresa_id = Auth::user()->empresa_id;
        $empresa = Empresa::find($empresa_id);
        $timestamp = strtotime("-30 days");
        $data = date('Y-m-d H:i:s', $timestamp);
        $relatorio_envio = SmsRelatorio::where('empresa_id', $empresa_id)
        ->where('created_at','>=',$data)
        ->orderBy('id','DESC')
        ->get();
        
        //carregando da tabelas sms_log_erros realizando contagem agrudapos por data 
        $log_erro = SmsLogErro::where('empresa_id',$empresa_id)
        ->count();   
       
        return view('relatorios_index', compact('relatorio_importacao',
        'empresa','relatorio_envio','log_erro'));
    }
}
