<?php

namespace App\Http\Controllers\Ppra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\Psmid\CadEmpresa;
use App\Http\Middleware\Psmid\RandonPassword;
use App\Http\Middleware\Psmid\CadUser;
use App\Http\Middleware\Psmid\EmpresaSelect;
use App\Revenda;
use App\MasterDisparo;
use App\User;
use App\Empresa;
use App\Http\Middleware\Psmid\Revendaid;
use App\Http\Middleware\Psmid\EmpresaAlt;
use App\Http\Middleware\Psmid\MasterDisparoAlt;


class RevendaController extends Controller
{
    /**
     * Envia para formulário de cadastro de revendas
     */
    public function form(){
        $pprauser = session('pprauser');
        return view('ppra.cad_revenda');
    }
    /**
     * Faz cadastro da revenda
     */
    public function cadrevenda(Request $request)
    {
        //cadastrando a empresa
        //dd($request);
        $cadempresa = new CadEmpresa;
        $revenda_id = '0';
        $empresa_id = $cadempresa->cadempresa($request,$revenda_id);
        // recupera revenda_id cadastrado na classe CadEmpresa pois revenda_id foi colocado como ZErO
        $revenda_id = Revenda::where('empresa_id',$empresa_id)->first();
        //criando entrada em master_disparos
        $mdisparo = new MasterDisparo();
        $mdisparo->revenda_id   = $revenda_id->id;
        $mdisparo->saldo_geral  = 0;
        $mdisparo->save();
        
        $revenda_nome = $request->nome;
        //geração de sugestão de senha
        $passwd = new RandonPassword;
        $sugere_passwd = $passwd->getPassword(8);
        
        return view('ppra.cad_revenda_user', compact('empresa_id','revenda_nome','sugere_passwd'));
    }

    /**
     * Faz cadastro do usuário da revenda com status 3 para aguardar aceite das condições do usuário
     */
    public function caduser(Request $request)
    {
        $is_admim = 1;
        $status = 3;
        $new_user = new CadUser;
        $user_id = $new_user->caduser($request, $status, $is_admim);
        $revenda_id = Revenda::where('empresa_id',$request->empresa_id)->first();
        $revenda_id = $revenda_id->id;
        $empresa_dados = Empresa::where('id',$request->empresa_id)->first();
        $user = User::where('id',$user_id)->first();
        return view('ppra.cad_revendafim', compact('revenda_id','empresa_dados','user'));
        
    }
    /**
     * Lista revendas para administração 
     */
    public function listarevenda()
    {
        /*$revendas = Revenda::with('revendadados','masterdisparos')
        ->paginate(2); */
        $revendas = Revenda::join('empresas', 'empresa_id', '=', 'empresas.id')
        ->orderBy('empresas.nome', 'asc')->paginate(10);
        //dd($revendas);
        return view('ppra.revendas', compact('revendas'));
    }

    /**
     * Carrega dados da revenda a partir do id de empresa e também de users 
     * 
     */
    public function showrevenda($id)
    {
        //carrega dados da empresa com o id na tabela empresas
        $empresa_dados = new EmpresaSelect;
        $empresa = $empresa_dados->empSelect($id);
        // carrega id de revenda 
        $revenda = new Revendaid;
        $revenda_id = $revenda->revendaid($empresa->id);
        $saldo_master = MasterDisparo::where('revenda_id',$revenda_id)
        ->first();    
        return view('ppra.revenda', compact('empresa','revenda_id','saldo_master'));
    }
    /**
     * Carrega dados da empresa para formulário de alteração de dados
     */
    public function editaform($id)
    {
        $empresa_dados = new EmpresaSelect;
        $empresa = $empresa_dados->empSelect($id);
        return view('ppra.edit_revenda', compact('empresa'));
    }
    /**
     * Altera dados da empresa
     */
    public function alterarevenda(Request $request)
    {
        $altera = new EmpresaAlt;
        $altera->empresaalt($request);
        return redirect()->action('Ppra\RevendaController@showrevenda',['id' => $request->id]);
    }
    public function carregamaster(Request $request)
    {
        $alteramasterdisparo = new MasterDisparoAlt;
        $alteramasterdisparo->masterdisparoaltera($request);
        return redirect()->action('Ppra\RevendaController@showrevenda',['id' => $request->empresa_id]);
    }
   
}
