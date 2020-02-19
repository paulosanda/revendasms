<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Empresa;
use App\User;

class UserController extends Controller
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
            $empresa = Empresa::all();
            return view('admin.cad_user', compact('empresa'));
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
        $user = new User();
        $user->name = $request->name;
        $user->email    = $request->email;
        $user->is_admin = 0;
        $user->status   = 1;
        $user->empresa_id  = $request->empresa;
        $user->telefone = $request->celular;
        $user->password = bcrypt($request->password);
        $user->save();

        echo 'cadastro realizado com sucesso';
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
        $user = User::find($id);
        $empresa = Empresa::find($user->empresa_id);
        return view('admin.alt_user',compact('user','empresa'));
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
        $alt_user = User::where('id',$request->id)->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'status'    => $request->status,
            'telefone'  => $request->celular
        ]);
        if(isset($request->password)){
            $alt_user = User::where('id',$request->id)->update([
                'password' => bcrypt($request->password)
            ]);
        }
        $empresa = Empresa::with('listUser','disparo')->orderBy('nome')->paginate(10);
        return view('admin.empresas', compact('empresa'));
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
