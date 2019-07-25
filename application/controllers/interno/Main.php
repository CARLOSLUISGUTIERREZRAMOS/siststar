<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('adm/usuario_model');
        $AGENTEUSER = ((int) $this->session->username && strlen($this->session->username) === 6) ? TRUE : FALSE;
        if ($AGENTEUSER) {
            isset($this->session->username) ? $this->createObjUserAgenteSess($this->session->username) : header('Location: '.base_url());
        } else {
            isset($this->session->username) ? $this->createObjUserSess($this->session->username) : header('Location: '.base_url());
        }
    }

    public function index() {

        $this->template->set('titulo', 'PRINCIPAL');
        $this->template->load(null, 'main/v_main');
    }

    public function logout() {

//        $this->session->unset_userdata('userdata');
        $this->session->unset_userdata('username');
        $this->session->sess_destroy();
        header('Location: '.base_url());
    }

    private function createObjUserAgenteSess($codAgente) {
        $data_agenteuser = $this->usuario_model->createObjUserAgente($codAgente);
        while (!$data_agenteuser->EOF) {
            $agente_Codigo = $data_agenteuser->fields[1];
            $agente_NomnreAgente = $data_agenteuser->fields[5];
            $agente_Ruc = $data_agenteuser->fields[8];
            $this->session->set_userdata(array('id_usuario' => $agente_Codigo));
            $this->session->set_userdata(array('nombre' => $agente_NomnreAgente));
            $this->session->set_userdata(array('apellido' => ''));
            $this->session->set_userdata(array('cargo' => $agente_Ruc));
            $data_agenteuser->MoveNext();
        }
    }

    private function createObjUserSess($codUser) {
        $this->usuario_model->createObjUser($codUser);
        $this->session->set_userdata(array('id_usuario' => $this->usuario_model->getId_usuario()));
        $this->session->set_userdata(array('nombre' => $this->usuario_model->getNombre()));
        $this->session->set_userdata(array('apellido' => $this->usuario_model->getApellido()));
        $this->session->set_userdata(array('cargo' => $this->usuario_model->getNombre_cargo()));
        $this->session->set_userdata(array('id_rol' => $this->usuario_model->getId_rol()));
        $this->session->set_userdata(array('email' => $this->usuario_model->getEmail()));
    }

}
