<?
/**
 * Classe para selects de na tabela empresas
 */
namespace App\Repositories;
use App\Empresa;

class empresarepository
{
    protected $empresa;

    //conta saldo de disparos de revenda
    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function empresaselect($empresa_id)
    {
        return $this->empresa->with('listUser')->where('id', $empresa_id)->get();
    }
}