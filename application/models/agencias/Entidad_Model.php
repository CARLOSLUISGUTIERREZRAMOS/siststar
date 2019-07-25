<?php
namespace Models\agencias;
use \Illuminate\Database\Eloquent\Model as Eloquent;
class Entidad_Model extends Eloquent
{
	protected $connection = "db_agencia";
	protected $primaryKey = 'CodigoEntidad';
    protected $table = 'entidad';
    public $timestamps = false;

    public function Usuarios()
    {
        return $this->hasMany(new Personal_Model(),'CodigoEntidad');
    }
}