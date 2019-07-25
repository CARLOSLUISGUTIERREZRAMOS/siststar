<?php 
namespace Models\web\familia;
use \Illuminate\Database\Eloquent\Model as Eloquent;
class Familia_Model extends Eloquent
{
	protected $primaryKey = 'codigo';
    protected $table = 'familia';
    public $timestamps = false;
}