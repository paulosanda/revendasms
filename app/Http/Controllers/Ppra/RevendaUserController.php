<?php

namespace App\Http\Controllers\Ppra;
use App\User;
use App\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\Psmid\Useradmin;

class RevendaUserController extends Controller
{
    /**
     * carrega informações de usuário de revenda para edição
     */
    public function edit($id)
    {
        $user = new Useradmin;
        $user = $user->usercarrega($id);
        $empresa = Empresa::find($user->empresa_id);
        return view('ppra.revenda_user_alt', compact('user','empresa'));
    }

    public function update(Request $request)
    {
        $useralt = new Useradmin;
        $useralt->useraltera($request);
        return view('ppra.home', compact('useralt'));
    }
}
