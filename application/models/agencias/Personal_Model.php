<?php 
namespace Models\agencias;
use \Illuminate\Database\Eloquent\Model as Eloquent;
class Personal_Model extends Eloquent
{
	protected $connection = "db_agencia";
	protected $primaryKey = 'CodigoPersonal';
    protected $table = 'personal';
    public $timestamps = false;
}