<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\User;

class Useradmin
{
    /**
     * Carrega dados de usuário
     */
    public function usercarrega($id)
    {
        $user = User::find($id);
        
        return $user;
    }
    public function useraltera($request)
    {
        $user = User::where('id', $request->id)->update([
            'name'      => $request->name,
            'telefone'  => $request->celular,
            'email'     => $request->email,
            'status'    => $request->status
        ]);
        if(isset($request->password))
        {
            User::where('id', $request->id)->update([
                'password'      => bcrypt($request->password)
            ]);
        }
        return $user;
    }
}
