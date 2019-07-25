<?php

class Login extends CI_Controller {

    private $codUser;
    private $passUser;

    function __construct() {
        parent::__construct();
        $this->load->model('adm/usuario_model');
        $this->load->library('form_validation');
        $this->load->library('Seguridad/Password');
        $this->load->model("adm/usuario_model");
    }

    function index() {
        $INGRESO_AGENTE = FALSE;
        if ($this->session->username) {
            return header('Location: '.base_url('interno/main'));
        }
        else{
            $this->form_validation->set_rules('codigoUsuario', 'CODIGO USUARIO', 'required');
            $this->form_validation->set_rules('password', 'CONTRASEÑA', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('login/v_login');
            } else {
                $this->codUser = $this->input->post('codigoUsuario');
                $this->passUser = $this->input->post('password');
                //1. PRIMERO SE VERIFICA SI EL USUARIO EXISET EN LA DB
                $usuarioValido = $this->usuario_model->verificaUsuario($this->codUser);

                $parserInt_user = (int) $this->codUser;

                $cant_caracteres = strlen($parserInt_user);
                if ($usuarioValido) {
                    $res = $this->password->validarPassword($this->passUser, $this->usuario_model->validaPassword($this->codUser, $this->passUser));
                    if ($res) {
                        $this->setDatosSesion($this->codUser);
                        return header('Location: '.base_url('interno/main'));
                    } else {
                        header('Location: '.base_url());
                    }
                    header('Location: '.base_url());
                }
                header('Location: '.base_url());
            }
        }
    }

    protected function ValidaLoginUserAgente($user_agente, $pass_agente) {
        $data_agenteuser = $this->usuario_model->verificaUsuarioAgente_sqlserver($user_agente);
        while (!$data_agenteuser->EOF) {
            $agente_cod = $data_agenteuser->fields[0];
            $data_agenteuser->MoveNext();
        }
        if (!empty($agente_cod)) {
            return ($agente_cod === $user_agente && $user_agente === $pass_agente) ? TRUE : FALSE;
        } else {
            return FALSE;
        }
    }

    public function muestraMensajePosRegistro($data) {

        $data['varCondicionModal'] = $data;
        $this->load->view('login/v_login', $data);
    }

    private function setDatosSesion($username) {
        $this->session->name;
        $this->session->set_userdata(array('username' => $username));
    }

}
