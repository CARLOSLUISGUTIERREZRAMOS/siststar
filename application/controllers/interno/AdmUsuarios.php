<?php

class AdmUsuarios extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('adm/usuario_model');

        $this->template->add_css('css/datatables/dataTables.bootstrap.min.css');
        $this->template->add_js('js/interno/usuario.js');
        $this->template->add_js('js/datatables/jquery.dataTables.min.js');
        $this->template->add_js('js/datatables/dataTables.bootstrap.min.js');

        $this->load->model("adm/usuario_model");
        $this->id_formulario = 1;
    }

    public function index() {
        $this->template->set('titulo', 'Administración de usuarios');
        $data["listaUsuarios"] = $this->listarUsuarios();
        $data["cargos"] = $this->usuario_model->getCargos();
        $data['ciudades'] = $this->usuario_model->getCiudades();
        $data['areas'] = $this->usuario_model->getAreaTrabajos();
        // var_dump($data["cargos"]->result());die;
        $this->template->load($this->id_formulario, 'interno/usuarios/v_cabecera_busqueda', $data);
    }

    private function listarUsuarios() {
        $res = $this->usuario_model->ListaUsuarios();
        return $res;
    }

    public function CambiarEstado() {

        $id_usuario = $_GET['id'];
        $estado = $this->usuario_model->getEstado($id_usuario);
        $UserRoot = $this->ValidaUsuarioRoot();
        
        if ($UserRoot) {
            $this->usuario_model->ActivaDesactUsuario(null,$CambiaEstado = ($estado === 'Y') ? 'N' : 'Y',$id_usuario);
            header('Location: '.base_url('interno/AdmUsuarios'));
        } else {
            $res = 'Accion no permitida';
        }
    }

    private function ValidaUsuarioRoot() {
        /*
         * ROOT = 1
         * ADM  = 2
         * USER = 3
         */
        $rol_user = (int) $_SESSION['id_rol'];
        return ($rol_user === 1 || $rol_user === 2) ? true : false;
    }

    public function VerUsuario()
    {
    	$id = $_GET['id'];
    	
    }

}
