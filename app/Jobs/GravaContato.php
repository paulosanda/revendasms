<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;
use Auth;
use App\User;
use App\Empresa;
use App\Cliente;
use App\ImportaRelatorio;
use App\ClienteGrupo;
use App\CargaContatoRelatorio;
use App\GrupoContato;
use Log;


class GravaContato implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $arquivo;
    public $cnome;
    public $cemail;
    public $cnascimento;
    public $csexo;
    public $empresa_id;
    public $grupo_contato;
    public $tries = 10;
    public $timeout = 900;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arquivo,$cnome,$cemail,$cnascimento,$csexo,$empresa_id,$grupo_contato)
    {
        $this->arquivo  = $arquivo;
        $this->cnome     = $cnome;
        $this->cemail    = $cemail;
        $this->cnascimento   = $cnascimento;
        $this->csexo     = $csexo;
        $this->empresa_id = $empresa_id;
        $this->grupo_contato = $grupo_contato;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $csvArray = $this->arquivo;
        $cnome = $this->cnome;
        $cemail = $this->cemail;
        $cnascimento = $this->cnascimento;
        $csexo = $this->csexo;
        $empresa_id = $this->empresa_id;
        $grupo_contato = $this->grupo_contato;
        
        
        //iniciando carga na base de dados
        $numero = count($csvArray);  //conta registros no arquivo
        $repetidos = 0; //declara var de numeros repetioos para ser inserido na tabela carga_conato_relatorios
        $carregados = 0;  //declara var de carregados repetioos para ser inserido na tabela carga_conato_relatorios
        //criando entrada na tabela carga_contato_relatorios
        //se houver grupo recuperando nome do grupo para ser inserido na observação
        $carga_contatos = new CargaContatoRelatorio();
        $carga_contatos->empresa_id             = $empresa_id;
        /* Gravação de relatório em carga_contato_relatorio destivado pois atrasa
        demais o processo
        if($grupo_contato !== 'none') {
            $grupo_contato_carrega = GrupoContato::find($grupo_contato);
            $carga_contatos->observacao         = $grupo_contato_carrega->tipo_grupo;
        }
        $carga_contatos->save();
        $carga_contato_id = $carga_contatos->id;*/

            
        for($i = 0; $i < $numero; $i++){
            //tratando telefone
            $telefone = $csvArray[$i]['telefone'];
            $telefone = str_replace('(','',$telefone);
            $telefone = str_replace(')','',$telefone);
            $telefone = str_replace('-','',$telefone);
            $telefone = str_replace('.','',$telefone);
            $telefone = str_replace(' ','',$telefone);
            //verificando se telefone está repetido
            $tel_repetido = Cliente::where([
                'empresa_id'    => $empresa_id,
                'telefone'      => $telefone
            ])->count();
            // se telefone estiver na lista não será duplicado contudo a função abaixo ira
            //recuperar o id do cliente para que este seja inserido no grupo apenas
            if($tel_repetido > 0) {
                $tel_para_grupo = Cliente::where([
                    'empresa_id'    => $empresa_id,
                    'telefone'      => $telefone
                ])->get();
                $telefone_repetido_id = $tel_para_grupo[0]['id']; // id do cliente
                $repetidos++; //soma um na var declara para numeros repetidos
                /* desativado 
                //atualiza carga_contato_relatorios
                CargaContatoRelatorio::where([
                    'id'            => $carga_contato_id,
                    'empresa_id'    => $empresa_id
                    ])->update(['telefone_repetido' => $repetidos]); */

                //verificar se numero repetido já está conta no grupo de contatos
                // - somente se for inserir em grupo
                if($grupo_contato !== 'none') {
                    $repetido_no_grupo = ClienteGrupo::where([
                        'cliente_id'    => $telefone_repetido_id,
                        'empresa_id'    => $empresa_id,
                        'grupo_contato_id'  => $grupo_contato
                    ])->count();
                    //se não está no grupo inserir
                    if($repetido_no_grupo < 1){
                        $grupo_insere = new ClienteGrupo();
                        $grupo_insere->empresa_id = $empresa_id;
                        $grupo_insere->cliente_id = $telefone_repetido_id;
                        $grupo_insere->grupo_contato_id = $grupo_contato;
                        $grupo_insere->save();
                        $gid = $grupo_insere->id; // id do cliente_grupos recem carregado
                        //carrega id em string [cliente_grupo_ids] para gravar em relatórios declarada no começo da funcao
                        /* desativaod
                        if(isset($cliente_grupo_ids)){
                            //carregando cliente_grupo_ids se relatório já foi iniciado
                            $cli_gr = CargaContatoRelatorio::find($carga_contato_id);
                            $add_cli_gr_id = $cli_gr->cliente_grupo_ids.','.$gid;
                            $alter_cli_gr = CargaContatoRelatorio::where('id',$carga_contato_id)
                            ->update(['cliente_grupo_ids' => $add_cli_gr_id]);
                        }
                        else {
                            //se não está carregado insere primeiro valor no campo
                            $alter_cli_gr = CargaContatoRelatorio::where('id',$carga_contato_id)
                            ->update(['cliente_grupo_ids' => $gid]);
                            $cliente_grupo_ids = 1;
                        } */

                    }
                }
            } // final da verificação se o telefone está repetido
            //inserindo novo cliente na tabela clientes
            else {
                $cli= new Cliente();
                $cli->empresa_id = $empresa_id;
                $cli->telefone = $telefone;
                //se foi escolhido inserir nome 
                    if($cnome == 1){
                        $cli->nome = $csvArray[$i]['nome'];
                    }
                    //se foi escolhida inserir email
                    if($cemail == 1){
                        $cli->email = $csvArray[$i]['e-mail'];
                    }
                    //se foi escolhida inserir data de nascimento
                    if($cnascimento == 1){
                        $data_nova = implode("-", array_reverse(explode("/", 
                        $csvArray[$i]['nascimento'])));
                        $cli->nascimento = $data_nova;
                    }
                    // se foi escolhido inserir sexo
                    if($csexo == 1){
                        $cli->sexo = $csvArray[$i]['sexo'];
                    }
                $cli->save();
                $carregados++;
                /* desativado
                CargaContatoRelatorio::where('id',$carga_contato_id)
                    ->update(['telefone_carregado' => $carregados]);
                */
                $cliente_id = $cli->id; // recuperando id do novo cliente registrado
                //carrega id em clientes_inserts_ids
                    /* destivado
                if(isset($clientes_inserts_ids)){
                    //recupera ids de clientes em cliente_inserts_ids
                    $cli_inserts = CargaContatoRelatorio::find($carga_contato_id);
                    $cli_ids = $cli_inserts->clientes_inserts_ids. ','. $cliente_id;
                    CargaContatoRelatorio::where('id',$carga_contato_id)
                    ->update(['clientes_inserts_ids' => $cli_ids]);
                }
                else {
                    // se var $clientes_inserts_ids não foi declarada ainda declara e insere primeiro id
                    CargaContatoRelatorio::where('id',$carga_contato_id)
                    ->update(['clientes_inserts_ids' => $cliente_id]);
                    $clientes_inserts_ids = 1;
                }    */
                //insere no grupo se for  o caso
                if($grupo_contato !== 'none') {
                    $grupo_insere = new ClienteGrupo();
                    $grupo_insere->empresa_id = $empresa_id;
                    $grupo_insere->cliente_id = $cliente_id;
                    $grupo_insere->grupo_contato_id = $grupo_contato;
                    $grupo_insere->save();
                    $gid = $grupo_insere->id;
                    /* destativaado
                    // insere $cliente_grupo_ids 
                    if(isset($cliente_grupo_ids)){
                        //carregando cliente_grupo_ids se relatório já foi iniciado
                        $cli_gr = CargaContatoRelatorio::find($carga_contato_id);
                        $add_cli_gr_id = $cli_gr->cliente_grupo_ids.','.$gid;
                        $alter_cli_gr = CargaContatoRelatorio::where('id',$carga_contato_id)
                        ->update(['cliente_grupo_ids' => $add_cli_gr_id]);
                    }
                    else {
                        // se $cliente_grupo_ids não foi declarada declara e insere o primeiro
                        $alter_cli_gr = CargaContatoRelatorio::where('id',$carga_contato_id)
                            ->update(['cliente_grupo_ids' => $gid]);
                            $cliente_grupo_ids = 1;
                    } */
                      
                }
            }
        }
        //carrega nome do grupo de contatos
       /* if($grupo_contato !== 'none') {
            $grupo_contato_carrega = GrupoContato::find($grupo_contato);    
            $grupo_contato_nome = $grupo_contato_carrega->tipo_grupo;
        }
        // carrega dados em tabela carga_de_contatos
        $carga_contatos = new CargaContatoRelatorio();
        $carga_contatos->empresa_id             = $empresa_id;
        if(isset($clientes_inserts_ids)){
            $carga_contatos->clientes_inserts_ids   = $clientes_inserts_ids;
        }
        if(isset($cliente_grupo_ids)){
            $carga_contatos->cliente_grupo_ids      = $cliente_grupo_ids;
        }
        $carga_contatos->telefone_carregado     = $carregados;
        $carga_contatos->telefone_repetido      = $repetidos;
        if(isset($grupo_contato_nome)){
            $carga_contatos->observacao             = $grupo_contato_nome;
        }
        $carga_contatos->save(); */
    }
}
