<?php

class Usuario_has_formulario_grupo_model extends CI_Model{
    
    private $id_usuario;
    private $id_formulario;
    private $id_grupo;
    protected $tbl;
    
    function __construct() {
        parent::__construct();
        
        $this->tbl = 'usuario_has_formulario_grupo';
    }
    
    public function getGrupos($id_usuario){

        $this->db->select('id_grupo');
        $data = $this->db->get_where($this->tbl, array('id_usuario' => $id_usuario));
        foreach($data->result() as $row){
            $this->id_formulario = $row->id_formulario;
            $this->setId_grupo($row->id_grupo);
        }
        
    }
    
    function getId_usuario() {
        return $this->id_usuario;
    }

    function getId_formulario() {
        return $this->id_formulario;
    }

    function getId_grupo() {
        return $this->id_grupo;
    }

    function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    function setId_formulario($id_formulario) {
        $this->id_formulario[] = $id_formulario;
    }

    function setId_grupo($id_grupo) {
        $this->id_grupo[] = $id_grupo;
    }


    
    
    
}
