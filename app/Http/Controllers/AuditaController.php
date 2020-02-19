<?php
/**
 * O HEAD DO ARQUIVO DE RETORNO PARA SER ANALISADO DEVE TER OS
 * SEGUINTES ITENS
 * Codigo
 * DataEnvio
 * SMS
 * Status
 * Part
 * Se estes indices forem alterados é preciso mudar o código
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\Psmid\Csvconverte;
use App\Http\Middleware\Psmid\CheckLogErros;
use App\SmsRelatorio;
use App\SmsLogErro;
use App\Cliente;


class AuditaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.audita_arquivo');
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
     * Executa auditoria com arquivo de retorno da MEX10
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function audita(Request $request)
    {
        
        $file = $request->file('arquivo'); // insere arquivo envado na var file
        $arquivo = new Csvconverte($file); // declara classe e insere file
        $arq = $arquivo->getimport_csv_to_array(); // executa método
        
        foreach($arq as $a) 
        {
            
            //carregando o id envio em  
            $empresa_id = SmsRelatorio::select('empresa_id')
            ->where('id', $a['CodCustomer'])->first();       

            if(isset($empresa_id))
            {
                if($a['Status'] == 'Erro')
                {
                    // Verifica se o telefone já consta em sms_log_erro
                    $erro = new CheckLogErros;
                    $erro = $erro->getRepetido($empresa_id->empresa_id, $a['Numero']);
                    // se não está inserir
                    if($erro == 0)
                    {
                        $smslogerro = new SmsLogErro();
                        $smslogerro->empresa_id = $empresa_id->empresa_id;
                        $smslogerro->telefone = $a['Numero'];
                        $smslogerro->created_at = $a['DataEnvio'];
                        $smslogerro->updated_at = $a['DataEnvio'];
                        $smslogerro->save();
                    } 
                }
                
            }
            

        }
        return redirect('SmsErroAdmin');
        
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
