<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Log_Model extends CI_Model {

    protected $tbl;
    private $id_accion;
    private $fecha_hora;
    private $usuario_id_afec;
    private $ip;

    public function __construct() {
        parent::__construct();
        $this->tbl = 'log';
    }

    function guardar_log($data) {

        $this->db->insert($this->tbl, $data);
        return $this->db->last_query();
        
    }

    function selectLogCumpleanios() {

        $this->db->select('id_usuario,accion.descripcion,personal.codigo,'
                . 'personal.nombres, personal.apellidos, personal.correo, log.fecha_hora');
        $this->db->from($this->tbl);
        $this->db->join('accion', "accion.id_accion = log.id_accion");
        $this->db->join('personal', "personal.codigo = log.usuario_id_afect",'RIGHT');
        $this->db->join('usuario', "usuario.id_usuario = log.usuario_id_exe");
        $this->db->order_by("log.fecha_hora", "DESC");
        $query = $this->db->get();
//        return $this->db->last_query();
        return $query;
    }

}

?>
