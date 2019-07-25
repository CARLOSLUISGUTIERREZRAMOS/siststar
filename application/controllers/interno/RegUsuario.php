<?php

error_reporting(1);

class RegUsuario extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('funciones_generales');
        $this->load->model("adm/cargo_model");
        $this->load->model("adm/ciudad_model");
        $this->load->model("adm/area_trabajo_model");
        $this->load->model("adm/log_error_model");
    }

    public function registrar() {
        $activo = 'Y';
        $data['cargo'] = $this->cargo_model->retornaDataAll($activo);
        $data['ciudad'] = $this->ciudad_model->retornaDataAll($activo);
        $data['area_trabajo'] = $this->area_trabajo_model->retornaDataAll($activo);


//            $this->load->view('login/v_login',$data);          
        $this->load->view('login/v_registro', $data);
    }

    public function valida() {

        $this->template->add_js('js/app/genericas.js');
        $this->form_validation->set_rules('regNombre', 'NOMBRE', 'required');
        $this->form_validation->set_rules('regApellido', 'APELLIDO', 'required');
        $this->form_validation->set_rules('regEmail', 'EMAIL', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->registrar(); //VOLVEMOS A LA VISTA DE FORMULARIO.
        } else {
            //SE PROCEDE CON LAS VALIDACIONES Y EL REGISTRO
            $firstName = trim($this->input->post('regNombre'));
            $lastName = trim($this->input->post('regApellido'));
            $mail = trim($this->input->post('regEmail'));
            $cellPhone = validaCelular(trim($this->input->post('regCelular')));
            $annexed = trim($this->input->post('regAnexo'));
            $city = $this->input->post('regCiudad');
            $position = $this->input->post('regCargo');
            $workArea = $this->input->post('regAreaTrabajo');

            $this->registrarUsuario($firstName, $lastName, $mail, $cellPhone, $annexed, $city, $position, $workArea);
        }
    }

    private function registrarUsuario($firstName, $lastName, $mail, $cellPhone, $annexed, $city, $position, $workArea) {
        $this->load->library('Seguridad/password');
        $this->load->model("adm/usuario_model");
        $ip = $_SERVER["REMOTE_ADDR"];
        
        $codigo = $this->ArmaCodigoUsuario($firstName, $lastName);
        $pass = $this->password->generarPass();
        $pass_bcrypt = $this->password->encriptar_password($pass);
        $data = array(
            'codigo' => $codigo,
            'pass' => $pass_bcrypt,
            'nombre' => $firstName,
            'apellido' => $lastName,
            'email' => $mail,
            'cod_ciudad' => $city,
            'id_cargo' => $position,
            'codigo_area' => $workArea,
            'ip_location' => $ip,
            'celular' => $cellPhone,
            'anexo' => $annexed,
            'estado' => 'N',
        );

        $res_reg_user = $this->usuario_model->registra($data);

        if ($res_reg_user === TRUE) { // SI EL USUARIO SE INSERTO
            $usuarioPersonal = $this->ValidaUsuarioExiste($firstName, $lastName);
            //Validamos si el usuario existe en la tabla Personal.

            if ($usuarioPersonal) {
                /*
                 * 1.Si existe la coincidencia se le enviara automaticamente un email con 
                 * credenciales de acceso al sistema
                 * 2.El sistema debera cambiar el estado del usuario activo
                 */
                $data['tipoModal'] = 'modal-success';
                $data['mensaje'] = 'Sus credenciales se generaron automaticamente, hemos enviado los datos de acceso al correo electronico:  ' . $mail;
                $this->usuario_model->ActivaDesactUsuario($codigo,'Y');
                $this->enviarEmailUsuarioSolicitante($firstName, $lastName, $codigo, $mail, $pass);
            } else {
                /* $data
                 * Si no se encontraron coincidencias el sistema debera mostrar un 
                 * mensaje al usuario donde se le indicará que deberá mantenerse en
                 * espera hasta que se acepte su solicitud.
                 */
                $data['tipoModal'] = 'modal-warning';
                $data['mensaje'] = "Te enviaremos un correo despues de validar la informacion ingresada";
            }
        } else {
            /*
             * Aqui mostraremos un boton que nos permitirá regresar y moficiar 
             */
            $data["botonBack"] = TRUE;
            $data['tipoModal'] = 'modal-danger';
            $data['mensaje'] = "ESTE REGISTRO YA EXISTE.";
            $this->GuardarErrorRegistro($res_reg_user);
        }
        $this->load->view('login/v_registro_res', $data);
    }

    private function GuardarErrorRegistro($res) {

        $num_error = $res['code'];
        $descripcion = $res['message'];
        $data = array(
            'num_error' => $num_error,
            'descripcion' => $descripcion
        );
        $this->log_error_model->registrar($data);
    }

    private function enviarEmailUsuarioSolicitante($firstName, $lastName, $codigo, $email, $password) {

        $this->load->helper('email_helper');
        help_enviarEmail($firstName, $lastName, $codigo, $password, $email );
        
    }

    private function ArmaCodigoUsuario($firstName, $lastName) {
        $firstLetterName = substr($firstName, 0, 1);
        $splitLastName = explode(' ', $lastName);
        $firstLastName = $splitLastName[0];
        $codigo = strtoupper($firstLetterName) . strtoupper($firstLastName);
        return $codigo;
    }

    private function ValidaUsuarioExiste($firstName, $lastName) {

        $this->load->model('adm/personal_model');
        $res = $this->personal_model->BuscarPersonal($firstName, $lastName);
        return $res;
    }

}
