<?php
use Models\agencias\Entidad_Model;
use Models\agencias\Personal_Model;
class Agencias extends CI_Controller {
	public function __construct() {
        parent::__construct();
        isset($this->session->username) ? TRUE : header('Location: '.base_url());
        $this->load->helper('logsystemweb');
        $this->load->helper('funciones_generales');
        $this->load->helper('email');
        $this->load->library('form_validation');
        $this->template->add_css('css/toastr/toastr.css');
        $this->template->add_js('js/toastr/toastr.js');
        $this->template->add_css('css/select2/select2.min.css');
        $this->template->add_js('js/select2/select2.full.min.js');
        $this->template->add_css('css/datatables/dataTables.bootstrap.min.css');
        $this->template->add_js('js/datatables/jquery.dataTables.min.js');
        $this->template->add_js('js/datatables/dataTables.bootstrap.min.js');
    }

    public function index() {
        $this->template->add_js('js/agencias/agencias.js',1);
        $this->template->set("titulo", "Listado de Agencias");
        $entidades = Entidad_Model::with('Usuarios')->orderBy('CodigoEntidad','DESC')->get();
        // dd($entidades[0]);
        $data["entidades"]=$entidades;
        $this->template->load(153, 'agencias/agencia/v_agencias_listado',$data);
    }

    public function AsignarCredito()
    {
        $Linea= $_POST['Linea'];
        $CodigoEntidad= $_POST['CodigoEntidad'];
        $agencia=Entidad_Model::find($CodigoEntidad);
        $agencia->Linea=$Linea;
        $agencia->save();
        $data_linea['linea_send']=$agencia->Linea;
        $data_linea['email_send']=$agencia->Email;
        $data_linea['ruc_send']=$agencia->RUC;
        $data_linea['razon_social_send']=$agencia->RazonSocial;
        help_enviaEmailLineaCredito($data_linea);
        echo $agencia;
    }

    public function AgenciaEstado()
    {
        $CodigoEntidad= $_POST['CodigoEntidad'];
        $agencia=Entidad_Model::find($CodigoEntidad);
        if ($agencia->EstadoRegistro==1) {
            $agencia->EstadoRegistro=0;
            $msg='Agencia <strong>DESACTIVADO correctamente</strong>';
            
            $usuarios = Personal_Model::where('CodigoEntidad',$agencia->CodigoEntidad)->orderBy('CodigoPersonal','DESC')->get();
            foreach ($usuarios as $key => $desactivar) {
                $desactivar->EstadoRegistro=0;
                $desactivar->save();
            }
            $data['estado']=0;
        }
        else{
            $agencia->EstadoRegistro=1;
            $msg='Agencia <strong>ACTIVADO correctamente</strong>';
            
            $pass=generaPassword();
            $password=encrypt_base64($pass,"");
            $usuario = Personal_Model::where('CodigoEntidad',$agencia->CodigoEntidad)->where('CodigoTipo','G')->orderBy('CodigoPersonal','DESC')->first();
            $usuario->EstadoRegistro=1;
            $usuario->Password=$password;
            $usuario->save();
            $data['estado']=1;
            $data['nombres']=$usuario->Nombres.' '.$usuario->ApellidoPaterno.' '.$usuario->ApellidoMaterno;
            $data['usuario']=$usuario->CodigoUsuario;
            $data['password']=$pass;
        }
        $agencia->save();
        $data['ruc']=$agencia->RUC;
        $data['razonsocial']=$agencia->RazonSocial;
        $data['direccion']=$agencia->Direccion;
        $data['email']=$agencia->Email;
        help_enviaEmailEstadoAgencia($data);

        $agencias=Entidad_Model::orderBy('CodigoEntidad','DESC')->get();;
        $dato["entidades"]=$agencias;
        $view=$this->load->view('agencias/agencia/v_contenido_agencia',$dato,TRUE);
        echo json_encode([$view,$msg]);
        // echo $agencia;
    }

    public function Usuarios()
    {
        if (isset($_GET['CodigoEntidad']) && $_GET['CodigoEntidad']!="") {
            $CodigoEntidad= $_GET['CodigoEntidad'];
            $usuarios = Personal_Model::where('CodigoEntidad',$CodigoEntidad)->orderBy('CodigoPersonal','DESC')->get();
            if (count($usuarios)>0) {
                // dd($usuarios);
                $agencia=Entidad_Model::find($CodigoEntidad);
                $this->template->add_css('css/toastr/toastr.css');
                $this->template->add_js('js/toastr/toastr.js');
                $this->template->add_js('js/agencias/usuario.js',1);
                $this->template->set("titulo", "Listado de Usuarios de la Agencia <strong>".$agencia->RazonSocial."</strong> con N° RUC: ".$agencia->RUC);
                $data["usuarios"]=$usuarios;
                $this->template->load(154, 'agencias/usuario/v_usuarios_listado',$data);
            }
            else{
                header('Location: '.base_url().'agencias/Agencias');
            }
        }
        else{
            header('Location: '.base_url().'agencias/Agencias');
        }
    }

    public function UsuarioEstado()
    {
        $CodigoPersonal= $_POST['CodigoPersonal'];
        $usuario=Personal_Model::find($CodigoPersonal);
        if ($usuario->EstadoRegistro==1) {
            $usuario->EstadoRegistro=0;
            $msg='Usuario <strong>DESACTIVADO correctamente</strong>';
        }
        else{
            $usuario->EstadoRegistro=1;
            $msg='Usuario <strong>ACTIVADO correctamente</strong>';
        }
        $usuario->save();
        $usuarios = Personal_Model::where('CodigoEntidad',$usuario->CodigoEntidad)->orderBy('CodigoPersonal','DESC')->get();
        $data["usuarios"]=$usuarios;
        $view=$this->load->view('agencias/usuario/v_contenido_usuario',$data,TRUE);
        echo json_encode([$view,$msg]);
    }

    public function ResetearPaswoord()
    {
        $CodigoPersonal= $_POST['CodigoPersonal'];
        $pass=generaPassword();
        $password=encrypt_base64($pass,"");
        
        $usuario=Personal_Model::find($CodigoPersonal);
        $usuario->Password=$password;
        $usuario->save();

        $data['nombres']=$usuario->Nombres.' '.$usuario->ApellidoPaterno.' '.$usuario->ApellidoMaterno;
        $data['usuario']=$usuario->CodigoUsuario;
        $data['password']=$pass;
        $data['email']=$usuario->Email;
        help_enviaEmailResetearPassword($data);

        echo 'Contraseña reseteado para usuario <strong>'.$data['nombres'].'</strong>';
    }
        public function AgregarUsuario() {
        $pass=generaPassword();
        $password=encrypt_base64($pass,"");
        $codigoEntidad = $_POST['codigoEntidad2'];
        $entidad=Entidad_Model::find($codigoEntidad);
        $ruc=substr($entidad->RUC, 0,2);
        $dni = $_POST['dni'];
        $apePat = trim(strtoupper($_POST['apePat']));
        $apeMat = trim(strtoupper($_POST['apeMat']));
        $nombres = strtoupper($_POST['nombres']);
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $celular = $_POST['celular'];
        $tipo = $_POST['tipo'];
        $usuario = new Personal_Model();
        $usuario->CodigoEntidad = $codigoEntidad;
        $usuario->DNI = $dni;
        $usuario->ApellidoPaterno = $apePat;
        $usuario->ApellidoMaterno = $apeMat;
        $usuario->Nombres = $nombres;
        $usuario->Email = $email;
        $usuario->TelefonoOficina = $telefono;
        $usuario->Celular = $celular;
        $usuario->Tipo = $tipo;
        $usuario->CodigoUsuario = $ruc.$dni;
        $usuario->Password = $password;
        $usuario->save();
        $data['nombres']=$usuario->Nombres.' '.$usuario->ApellidoPaterno.' '.$usuario->ApellidoMaterno;
        $data['usuario']=$usuario->CodigoUsuario;
        $data['password']=$pass;
        $data['email']=$usuario->Email;
        help_enviaEmailResetearPassword($data);
        header('Location: ' . base_url() . 'agencias/Agencias/Usuarios?CodigoEntidad=' . $codigoEntidad);
    }

    public function EditarUsuario() {
        $codigoEntidad = $_POST['codigoEntidad'];
        $codigoPersonal = $_POST['codigoPersonal'];
        $dni = $_POST['dni'];
        $apePat = trim(strtoupper($_POST['apePat']));
        $apeMat = trim(strtoupper($_POST['apeMat']));
        $nombres = strtoupper($_POST['nombres']);
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $celular = $_POST['celular'];
        $tipo = $_POST['tipo'];

        $usuario = Personal_Model::find($codigoPersonal);
        $usuario->DNI = $dni;
        $usuario->ApellidoPaterno = $apePat;
        $usuario->ApellidoMaterno = $apeMat;
        $usuario->Nombres = $nombres;
        $usuario->Email = $email;
        $usuario->TelefonoOficina = $telefono;
        $usuario->Celular = $celular;
        $usuario->Tipo = $tipo;
        $usuario->save();
        header('Location: ' . base_url() . 'agencias/Agencias/Usuarios?CodigoEntidad=' . $codigoEntidad);
    }

}