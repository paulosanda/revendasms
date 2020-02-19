<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Estado;
use App\Cidade;
use App\PreCadastro;
use App\Mail\PreCadMail;
use App\Http\Middleware\Psmid\RandonKey;
use App\Http\Middleware\Psmid\SmsEnviaMid;
use App\Empresa;
use App\Mail\NovaConta;
use App\Http\Middleware\Psmid\CadEmpresa;
use App\Http\Middleware\Psmid\CadUser;



class PreCadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.precad');
    }

    public function precad(Request $request)
    {
       //codifique aqui o pré cadastro, inserir na base de dados e enviar email e sms com aviso
       $precaduser = new PreCadastro();
       $precaduser->nome    = $request->nome;
       $precaduser->telefone    = $request->telefone;
       $precaduser->email       = $request->email;
       $precaduser->save();
       // enviando aviso por email
       if($precaduser){
           $sucesso = 'O cadastro foi realizado com sucesso!';
           Mail::send(new PreCadMail());
           return view('admin.precad', compact('sucesso'));
       } else {
           $sucesso = 'Houve algum erro no cadastro, talvez o e-mail já esteja cadastrado';
           return view('admin.precad', compact('sucesso'));
       }
       
    }
    public function precadcancela($email){
        $precad = PreCadastro::where('email', $email)->first();
        $cancela =1;
        session()->put('nome',$precad->nome);
        return view('precadcancela', compact('precad','cancela'));
    }

    public function precadcancelado(Request $request){
        $cancelado = PreCadastro::where('id',$request->precad_id)->delete();
        return view('precadcancela', compact('cancelado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bemvindo($email)
    {
        $dados = PreCadastro::where('email', $email)->first();
        session()->put('nome', $dados->nome);
        if($dados->tentativas < 5)
        {
            $code = new RandonKey;
            $code = $code->getCode(6);
            $insertCode = PreCadastro::where('id',$dados->id)->update([
                'code'  => $code,
                'tentativas' => $dados->tentativas +1
            ]);
            //Enviando SMS com código
            $mensagem = ' seu código SEO ADM é '.$code. ' ele é válido por 2 horas';
            $sms = new SmsEnviaMid;
            $nome = $dados->nome;
            $relatorio_id = 0;
            $telefone = $dados->telefone;
            $sms->smsenviamid($nome, $mensagem,$telefone, $relatorio_id);
            session()->put('telefone', $telefone);
            session()->put('email', $email);
            session()->flash('success', 1);
            session()->put('nome', $dados->nome);
            session()->put('precad_id', $dados->id);
            $bemvindo = 1;
            //$bemvindo = json_encode($bemvindo);
            
            return view('bemvindo', compact('dados','bemvindo'));
        } else {
            $multi = "O número máximo de tentativas foi alcançado, parece que você
            está tendo dificuldades, por favor entre em contato com seu consultor ou 
            pelo e-mail suporte@seo.adm.br";
            return view('bemvindo', compact('multi'));
        }
        
    }

        public function codigoverifica(Request  $request){
        $regras = [
            'codigo'     => 'required',
            'g-recaptcha-response' => 'required'
        ];
        $mensagens = [
            'codigo.required' => 'Acho que você esqueceu de inserir o código',
            'g-recaptcha-response.required' => "Você é um robô?",
        ];
        $request->validate($regras, $mensagens);
        $codigo = PreCadastro::where('id',$request->id)->first();
        //dd($codigo);
        $dataagora = date('Y-m-d H:m:i');
        $dataagora = strtotime($dataagora);
        $datavence = strtotime('+2 hour', strtotime($codigo->updated_at));
        
        if($codigo->code == $request->codigo && strtotime($dataagora)  <= $datavence){
            session()->flash('codigo', 1); //colocar aqui o código
            session()->put('email',$request->email);
            session()->flash('success', 2);
            $estado = Estado::all();
            return view('bemvindo', compact('estado'));
        }
        else{
            session()->flash('erro','O codigo informado está errado ou o prazo já expirou por favor tente novamente');
            return redirect()->back();
        }
    }

    public function getcidades($idEstado) {
        $cidades = Cidade::where('estado_id',$idEstado)->get();
        //dd($cidades);
        return response()->json($cidades);
    }

    public function precadempresa(Request $request)
    {
        //Cadastrando nova empresa e inserindo na tabela disparos para controle de saldo de disparos
        $cadempresa = new CadEmpresa;
        $empresa_id = $cadempresa->cadempresa($request);

        session()->flash('success', 3);
        return view('bemvindo', compact('empresa_id'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function precaduser(Request $request)
    {
        $regras = [
            'name'      => 'required',
            'email'     => 'required',
            'telefone'  => 'required',
            'password'  => 'required',
            'g-recaptcha-response' => 'required'
        ];
        $mensagens = [
            'name.required' => 'Qual seu nome?',
            'email.required' => 'E o email?',
            'telefone.required' => 'Qual seu celular?',
            'password.required' => 'Não se esqueça de colocar uma senha forte.',
            'g-recaptcha-response.required' => "Você é um robô?",
        ];      

        $request->validate($regras, $mensagens);
        //apagando registro na tabela pre_cadastros
        PreCadastro::where('id',$request->precad_id)->delete();

        // inserindo novo usuário com status 0
        $status = 0;
        $caduser = new CadUser;
        $user_id = $caduser->caduser($request, $status);

        $empresa = Empresa::find($request->empresa_id);
        $empresanome = $empresa->nome;
        $usuario = $request->name;
        $email = $request->email;
        $telefone = $request->telefone;
        
        Mail::send(new NovaConta());
        $finalizado = '1';
        $_SESSION = array();
        // o retorno está gerando erro no servidor, talvez
        //seja melhor fazer outra view pois até o e-mail é enviado logo
        // o problema tavles esteja no session 
        return view('precadfim', compact('finalizado','usuario'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancela($email)
    {
        echo $email; //rotina e página de cancelamento
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
