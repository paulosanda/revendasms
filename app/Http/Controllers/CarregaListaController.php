<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Auth;
use App\Cliente;
use Illuminate\Support\Facades\Redis;
use App\Jobs\GravaContato;
use App\Empresa;
use App\CargaContatoRelatorio;
use App\GrupoContato;
use App\ClienteGrupo;
use App\CrudConsultaCargaContatoRelatorio;

class CarregaListaController extends Controller
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
        $gruposcontatos = GrupoContato::where('empresa_id',$empresa_id)
        ->orderBy('tipo_grupo')->get();
        $empresa = Empresa::find($empresa_id);
        return view('carregalista', compact('gruposcontatos','empresa'));
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
       
    public function detalhes(Request $request)
    {
        $empresa_id = Auth::user()->empresa_id;
        //declar var cliente
        $cliente = array();
        //criando linha no CRUD
        $lista = CargaContatoRelatorio::find($request->carga_id);

        //carregando no crud os clientes inseridos 
        if(isset($lista->clientes_inserts_ids)){
            $cliente_lista = explode(',',$lista->clientes_inserts_ids);
            $numero = count($cliente_lista);
            if($numero > 0){
                for($i = 0; $i < $numero; $i++){
                    $cliente_dados = Cliente::find($cliente_lista[$i]);
                    $crud = new CrudConsultaCargaContatoRelatorio();
                    $crud->carga_contato_id = $request->carga_id;
                    $crud->cliente_id       = $cliente_lista[$i];
                    $crud->cliente_telefone =   $cliente_dados->telefone;
    
                    if(isset($cliente_dados->nome)){
                        $crud->cliente_nome = $cliente_dados->nome;        
                    }
                    if(isset($cliente_dados->nascimento)){
                        $crud->cliente_nascimento   =   $cliente_dados->nascimento;
                    }
                    if(isset($cliente_dados->email)){
                        $crud->cliente_email    = $cliente_dados->email;
                    }
                    if(isset($cliente_dados->sexo)){
                        $crud->cliente_sexo     = $cliente_dados->sexo;
                    }
                    $crud->save();
                }
            }
        }

        if(isset($lista->cliente_grupo_ids)){
            //carregando as inserções em grupo_contato
            $cliente_grupo = explode(',',$lista->cliente_grupo_ids);
            //carregando o tipo_grupo
            foreach($cliente_grupo as $cg){
                //carrega dados do cliente_grupos
                $cliente_grupo = ClienteGrupo::find($cg);
                //carregando tipo do grupo
                $tipo_grupo = GrupoContato::select('tipo_grupo')
                ->where('id',$cliente_grupo->grupo_contato_id)->first();
                //carregando dados do cliente
                $cliente_dados = Cliente::find($cliente_grupo->cliente_id);
                //verificar se cliente já foi carregado 
                $cliente_carregado = CrudConsultaCargaContatoRelatorio::where([
                    'carga_contato_id'  => $request->carga_id,
                    'cliente_id'        => $cliente_dados->id
                ])->count();
                if($cliente_carregado > 0){
                    $carrega_grupo = CrudConsultaCargaContatoRelatorio::where([
                        'carga_contato_id'  => $request->carga_id,
                        'cliente_id'        => $cliente_dados->id
                    ])->update([
                    'grupo'             => $tipo_grupo->tipo_grupo
                    ]);
                }
                else{
                    $carrega_no_grupo = new CrudConsultaCargaContatoRelatorio();
                    $carrega_no_grupo->carga_contato_id = $request->carga_id;
                    $carrega_no_grupo->cliente_id       = $cliente_dados->id;
                    $carrega_no_grupo->cliente_telefone       = $cliente_dados->telefone;
                    if(isset($cliente_dados->nome)){
                        $carrega_no_grupo->cliente_nome     = $cliente_dados->nome;
                    }
                    if(isset($cliente_dados->nascimento)){
                        $carrega_no_grupo->cliente_nascimento   = $cliente_dados->nascimento;
                    }
                    if(isset($cliente_dados->email)){
                        $carrega_no_grupo->cliente_email   = $cliente_dados->email;
                    }
                    if(isset($cliente_dados->sexo)){
                        $carrega_no_grupo->cliente_sexo   = $cliente_dados->sexo;
                    }
                    $carrega_no_grupo->grupo   = $tipo_grupo->tipo_grupo;
                    $carrega_no_grupo->observacao   = 'gravado apenas para grupo '. $tipo_grupo->tipo_grupo;
                    $carrega_no_grupo->save();
                }
            }
        }

        $lista_a = CrudConsultaCargaContatoRelatorio::where('carga_contato_id',$request->carga_id)
        ->get();
        $crud_apaga = CrudConsultaCargaContatoRelatorio::where('carga_contato_id',$request->carga_id)
        ->delete();
        $carga_id = $request->carga_id;
        $empresa = Empresa::find($empresa_id);

        return view('descreve_lista',compact('lista_a','empresa','carga_id'));
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

    public function carregalista(Request $request) 
    {
        $regras = [
            'ctelefone'   => 'required',
            'arquivo'     => 'required'
        ];
        $mensagens = [
            'ctelefone.required' => 'Você desmarcou telefone, este campo é obrigatório',
            'arquivo.required' => 'É preciso enviar um arquivo CSV',
         
        ];
        $request->validate($regras, $mensagens);

        ///função para carregar arquivo em array
        //converte codificação para utf8
        function utf8_converter($array) {
            array_walk_recursive($array, function(&$item, $key){
                if(!mb_detect_encoding($item, 'utf-8', true)){
                    $item = utf8_encode($item);
                }
            });
            return $array;
        }
        // para saber qual a codificação do arquivo
        function codificacao($string) {
            return mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
        }
        //declarando a função identificar delimitadores
        function detect_delimiter($csv_string) {
            $delimiters = array(';' => 0,"\t" => 0,"|" => 0);
            foreach ($delimiters as $delimiter => &$count) {
                $count = substr_count($csv_string,$delimiter);
            }
            return array_search(max($delimiters), $delimiters);
        }
        //declarando a função para carregar o CSV
        function import_csv_to_array($file,$enclosure = '"') {
            $csv_string = file_get_contents($file);
            $delimiter = detect_delimiter($csv_string);
            $lines = explode("\n", $csv_string);
            $head = str_getcsv(array_shift($lines),$delimiter,$enclosure);
            $head = utf8_converter($head);  
            $array = array();
            foreach ($lines as $line) {
                if(empty($line)) {
                    continue;
                }
                $csv = $line;
                $codifica = codificacao($csv);
                $csv = explode(';',$csv);
                if($codifica !== 'UTF-8') {
                    $num = count($csv);
                    $csv_en = array();
                    for($i = 0; $i < $num; $i++){
                        $csv_it = utf8_encode($csv[$i]);
                        array_push($csv_en,$csv_it);
                    }
                    $csv = $csv_en;
                }    
                // Combine the header and the lines data
                $array[] = array_combine( $head, $csv );                
                }
                return $array;
            } 

        // fim da função
        $file = $request->file('arquivo');
        $empresa_id = Auth::user()->empresa_id;
        //echo 'O id da empresa é '.$empresa_id;
        $arquivo = import_csv_to_array($file,$enclosure = ';');
        
        //GravaContato::dispatch($arquivo, $request->cnome,$request->cemail,
        //$request->cnascimento,$request->csexo,$empresa_id)->allOnConnection('redis')->onQueue('importando');
        GravaContato::dispatch($arquivo, $request->cnome,$request->cemail,
        $request->cnascimento,$request->csexo,$empresa_id,$request->grupo_contato);
        return view('listacarregando') ;
    }

    public function apaga(Request $request) 
    {
        /*
        $empresa_id = Auth::user()->empresa_id;
        $data_hora = $request->data_hora;
        $data = explode(" ",$data_hora);
        // configurando data para o select 5 minutos para mais e 5 para menos
        $hora = explode(":",$data[1]);
        $minutomais = $hora[1]+5;
        $minutomenos = $hora[1]-5;
        $data1 = $data[0].' '.$hora[0].':'.$minutomenos.':'.$hora[2];
        $data2 = $data[0].' '.$hora[0].':'.$minutomais.':'.$hora[2];
        //obtendo clientes do intervalo
        $lista = Cliente::where('empresa_id',$empresa_id)
        ->whereBetween('updated_at',[$data1,$data2])->
        where('empresa_id',$empresa_id)->get();
        //deletendo cliente da tabela cliente_grupos de acordo com intervalo
        foreach($lista as $l){
            $deleta_do_grupo = ClienteGrupo::where('cliente_id',$l['id'])
            ->whereBetween('updated_at',[$data1,$data2])->
            where('empresa_id',$empresa_id)->delete();
            //verificando se cliente está em outros grupos
            $outros_grupos = ClienteGrupo::where('cliente_id',$l['id'])->count();
            //se não estiver apagar o Cliente
            if($outros_grupos < 1) {
                $apaga_cliente = Cliente::where('id',$l['id'])->delete();
            }
        }

        //carregando dados da empresa
        $empresa = Empresa::find($empresa_id);
        // deletando relatório
        $del_relatorio = ImportaRelatorio::where('id',$request->relatorio_id)->
        where('empresa_id',$empresa_id)->delete(); */
        $carga_grupo_relatorio = CargaContatoRelatorio::find($request->carga_id);
        //apagando em grupos se houver cliente_grupo_ids
        if(isset($carga_grupo_relatorio->cliente_grupo_ids)){
            $cliente_grupo_apaga = explode(',',$carga_grupo_relatorio->cliente_grupo_ids);
            foreach($cliente_grupo_apaga as $cga){
               ClienteGrupo::where('id',$cga)->delete();
            }
        }
        //apagando em clientes antes verificando se não está em outros grupos
        if(isset($carga_grupo_relatorio->clientes_inserts_ids)){
            $cliente_ids = explode(',', $carga_grupo_relatorio->clientes_inserts_ids);
            //verifica se cliente não está em outros cliente_grupos
            foreach($cliente_ids as $ci){
                $cliente_grupo_existe = ClienteGrupo::where('cliente_id',$ci)->count();
                if($cliente_grupo_existe < 1){
                    Cliente::find($ci)->delete();
                }
            }
            

        }
        CargaContatoRelatorio::where('id',$request->carga_id)->delete();

        return redirect('relatorios_index');
    }
}
