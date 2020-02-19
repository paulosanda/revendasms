<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Empresa;
use App\Cliente;
use App\Jobs\SmsEnvia;
use App\Jobs\SmsNiver;
use App\Jobs\SmsGrupo;
use App\Disparo;
use App\SmsLogErro;
use App\GrupoContato;
use App\ClienteGrupo;
use App\Http\Middleware\Psmid\RegSmsRelatorio;

class EnvioController extends Controller
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
        // carrega id da empresa
        $empresa_id = Auth::user()->empresa_id;
        // carrega dados da empresa e disparos para passar para view
        $empresa = Empresa::with('disparo')->where('id',$empresa_id)->get();
        // contando total de clientes para view
        $clientes = Cliente::where('empresa_id',$empresa_id)->count();
        //contando aniversariantes do mês para passar para view
    

        return view('sms_envia',compact('empresa','clientes'));
    }
    ///para listar grupos na escolha de envio
    public function grupo()
    {
        // carrega id da empresa
        $empresa_id = Auth::user()->empresa_id;
        // carrega dados da empresa e disparos para passar para view
        $empresa = Empresa::with('disparo')->where('id',$empresa_id)->get();
        // contando total de clientes para view
        $clientes = Cliente::where('empresa_id',$empresa_id)->count();
        //contando aniversariantes do mês para passar para view
        $aniversarios = Cliente::where('empresa_id',$empresa_id)->whereMonth('nascimento',date('m'))->count();
        //carregando grupo_contatos com relacionamento em cliente_grupos
        $aniversarios_hoje = Cliente::where('empresa_id',$empresa_id)->whereMonth('nascimento',date('m'))
        ->whereDay('nascimento',date('d'))
        ->count();
        //carregando grupo_contatos com relacionamento em cliente_grupos
        $grupos = GrupoContato::with('cliente_grupo')->where('empresa_id',$empresa_id)->get();

        return view('sms_grupo',compact('empresa','clientes','aniversarios','grupos','aniversarios_hoje'));
    }
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function grupo_form(Request $request)
    {
        $empresa_id = Auth::user()->empresa_id;
        $empresa = Empresa::with('disparo')->where('id',$empresa_id)->get();
        //se for para aniversariantes do mes
        if($request->grupo_id == 'aniversario_mes'){
            $aniversarios_mes = Cliente::where('empresa_id',$empresa_id)->whereMonth('nascimento',date('m'))->count();
            $lista = $aniversarios_mes;
            $grupo_id = 'aniversario_mes';
            return view('sms_envia_grupo', compact('aniversarios_mes','empresa','lista','grupo_id'));
        }
        //se for para aniversiantes do dia
        if($request->grupo_id == 'aniversario_hoje'){
            $aniversarios_hoje = Cliente::where('empresa_id',$empresa_id)->whereMonth('nascimento',date('m'))
            ->whereDay('nascimento',date('d'))
            ->count();
            $lista = $aniversarios_hoje;
            $grupo_id = 'aniversario_hoje';
            return view('sms_envia_grupo', compact('aniversarios_hoje','empresa','lista','grupo_id'));
        }
        if($request->grupo_id !== 'aniversario_mes' OR $request->grupo_id !== 'aniversario_hoje'){
            $clientes_grupo = ClienteGrupo::where([
                'empresa_id'    => $empresa_id,
                'grupo_contato_id'  => $request->grupo_id
            ])
            ->count();
            $lista = $clientes_grupo;
            $grupo_nome = GrupoContato::find($request->grupo_id);
            $grupo_id = $grupo_nome->id;
            return view('sms_envia_grupo', compact('empresa','lista','grupo_id','grupo_nome'));
        }

    }
    public function grupo_confirma(Request $request)
    {
        $grupo_id = $request->grupo_id;
        $grupo = $request->grupo_tipo;
        $mensagem = $request->mensagem;
        $mensagem = str_replace("\n", ' ', $mensagem);
        $mensagem = str_replace("\r", ' ', $mensagem);
        $q_caracter = strlen($mensagem);
        $empresa = Empresa::where('id',Auth::user()->empresa_id)->get();

        return view('sms_grupo_confirma', compact('mensagem','q_caracter','empresa','grupo_id','grupo'));
    }
    ///envio para grupo
    public function grupo_enviar(Request $request)
    {
        $empresa_id = Auth::user()->empresa_id; 
        $relatorio_id = new RegSmsRelatorio;
        $relatorio_id = $relatorio_id->getRelatorioId($empresa_id, $request->mensagem);
         
        //verificando tipo de envio se aniversario do mês, do dia ou grupo
        if($request->grupo_id == 'aniversario_mes'){
            $t_contato = Cliente::where('empresa_id',$empresa_id)->whereMonth('nascimento',date('m'))
            ->count();
            $contatos = Cliente::where('empresa_id',$empresa_id)->whereMonth('nascimento',date('m'))
            ->get();   
            SmsNiver::dispatch($empresa_id,$request->mensagem,$contatos, $relatorio_id);         
        }
        if($request->grupo_id == 'aniversario_hoje'){
            $t_contato = Cliente::where('empresa_id',$empresa_id)->whereMonth('nascimento',date('m'))
            ->whereDay('nascimento',date('d'))
            ->count();
            $contatos = Cliente::where('empresa_id',$empresa_id)->whereMonth('nascimento',date('m'))
            ->whereDay('nascimento',date('d'))
            ->get();
            SmsNiver::dispatch($empresa_id,$request->mensagem,$contatos, $relatorio_id); 
        }
        if($request->grupo_id != 'aniversario_mes' AND $request->grupo_id != 'aniversario_hoje') {          
                $t_contato = ClienteGrupo::where([
                'empresa_id'    => $empresa_id,
                'grupo_contato_id'  => $request->grupo_id
                ])->count();
                $contatos = ClienteGrupo::where([
                'empresa_id'    => $empresa_id,
                'grupo_contato_id'  => $request->grupo_id
                ])->get();  
                SmsGrupo::dispatch($empresa_id,$request->mensagem,$contatos, $relatorio_id); 
        }
        
        // retirando do saldo de disparos
        $saldo =  Disparo::where('empresa_id',$empresa_id)->get();
        $nsaldo = $saldo[0]['saldo'] - $t_contato;
        $atualiza = Disparo::where('empresa_id',$empresa_id)->update([
        'saldo' =>$nsaldo
        ]);
        $empresa = Empresa::find($empresa_id);

        //SmsEnvia::dispatch($empresa_id,$mensagem);
        return view('sms_enviando', compact('empresa')) ;
    }



    public function enviaconfirma(Request $request)
    {
        $mensagem = $request->mensagem;
        $mensagem = str_replace("\n", ' ', $mensagem);
        $mensagem = str_replace("\r", ' ', $mensagem);
        $q_caracter = strlen($mensagem);
        $empresa = Empresa::where('id',Auth::user()->empresa_id)->get();

        return view('sms_envia_confirma', compact('mensagem','q_caracter','empresa'));
    }

    public function envia(Request $request)
    {
        $regras = [
            'mensagem'   => 'required',
           
         ];
         $mensagens = [
             'mensagem.required' => 'É preciso escrever uma mensagem',
         ];

        $empresa_id = Auth::user()->empresa_id;
        $mensagem = $request->mensagem;

        $relatorio_id = new RegSmsRelatorio;
        $relatorio_id = $relatorio_id->getRelatorioId($empresa_id, $mensagem);   
        
        //contando contatos
        $t_contato = Cliente::where('empresa_id',$empresa_id)->count();
        // retirando do saldo de disparos
        $saldo =  Disparo::where('empresa_id',$empresa_id)->get();
        $nsaldo = $saldo[0]['saldo'] - $t_contato;
        $atualiza = Disparo::where('empresa_id',$empresa_id)->update([
        'saldo' =>$nsaldo
        ]);
        $empresa = Empresa::find($empresa_id);

        SmsEnvia::dispatch($empresa_id,$mensagem, $relatorio_id);
        return view('sms_enviando', compact('empresa')) ;
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
