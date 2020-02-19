<?php

namespace App\Http\Middleware\Psmid;

use Closure;
use App\User;


class CadUser
{
    public function caduser($request, $status) {
        $this->request = $request;
        $this->status = $status;
        $n_user = new User();
        $n_user->name       = $request->name;
        $n_user->email      = $request->email;
        $n_user->is_admin   = 0;
        $n_user->status     = $status;
        $n_user->empresa_id = $request->empresa_id;
        $n_user->telefone   = $request->telefone;
        $n_user->password   = bcrypt($request->password);
        $n_user->save();
        $user_id = $n_user->id;
        return $user_id;
    }
    
}
