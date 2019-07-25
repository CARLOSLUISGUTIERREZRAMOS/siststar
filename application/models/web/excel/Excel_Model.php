<?php
namespace Models\web\excel;
use \Illuminate\Database\Eloquent\Model as Eloquent;
class Excel_Model extends Eloquent
{
    protected $table = 'reserva';

    public function Detalles()
    {
        return $this->hasMany(new Detalle_Model(),'reserva_id');
    }
}