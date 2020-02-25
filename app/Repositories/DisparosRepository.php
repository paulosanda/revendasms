<?
/**
 * Classe para selects de na tabela disparos
 */
namespace App\Repositories;
use App\Disparo;

class disparosrepository
{
    protected $disparo;

    //conta saldo de disparos de revenda
    public function __construct(Disparo $disparo)
    {
        $this->disparo = $disparo;
    }

    public function somadisparo($revenda_id)
    {
        return $this->disparo->where('revenda_id', $revenda_id)->sum('saldo');
    }
}