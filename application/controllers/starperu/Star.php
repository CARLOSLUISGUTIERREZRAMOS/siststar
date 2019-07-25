<?php
use Models\web\familia\Familia_Model;
class Star extends CI_Controller {

    public function __construct() {
        parent::__construct();
        isset($this->session->username) ? TRUE : header('Location: '.base_url());
        $this->load->helper('logsystemweb');
        $this->load->library('form_validation');
    }

    function index() {
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.js',1);
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.es.min.js');
        $this->template->add_js('https://www.starperu.com/es/js/starperu/starperu.js',1);
        $this->template->add_js('js/starperu/star.js',1);
        $this->template->set("titulo", "Carousel de Imágenes");
        $this->template->load(150, 'starperu/v_carousel');
    }

    public function ModificarObjetoJson()
    {
        $objstar='objstar='.$_GET['objstar'];
        crear_objeto_js($objstar,'starperu');
        echo "ok";
    }

    private function ValidarPostInput($data) {
        if ($data['banner']==1) {
            $this->form_validation->set_rules('desde', 'Fecha Inicio', array('regex_match[/^(([0-2][0-9]|3[0-1])(\/)(0[1-9]|1[0-2])(\/)([0-9]{4}))$/]', 'min_length[10]', 'max_length[10]', 'required'));
            $this->form_validation->set_rules('hasta', 'Fecha Fin', array('regex_match[/^(([0-2][0-9]|3[0-1])(\/)(0[1-9]|1[0-2])(\/)([0-9]{4}))$/]', 'min_length[10]', 'max_length[10]', 'required'));
            $this->form_validation->set_rules('inicio', 'Hora Inicio', array('regex_match[/^(([0-1][0-9]|2[0-3])(:)([0-5][0-9])(:)([0-5][0-9]))$/]', 'min_length[8]', 'max_length[8]', 'required'));
            $this->form_validation->set_rules('fin', 'Hora Fin', array('regex_match[/^(([0-1][0-9]|2[0-3])(:)([0-5][0-9])(:)([0-5][0-9]))$/]', 'min_length[8]', 'max_length[8]', 'required'));
        }
        $this->form_validation->set_rules('estado', 'Estado', 'required|min_length[1]|max_length[1]');
        $this->form_validation->set_rules('tipo', '', 'required|min_length[1]|max_length[1]');
    }

    public function GuardarRegistro()
    {
        $post_xss=$this->input->post(NULL, TRUE);
        $this->ValidarPostInput($post_xss);
        if($this->form_validation->run() == true){
            //tipo = 1 ->Store
            //tipo = 2 ->Edit
            if ($post_xss["tipo"]==1) {
                $name=$this->GuardarImagen();
                if ($name!="") {
                    $url=base_url('/uploads/').$name;
                    $data=$this->ArmarObjeto($post_xss,$url);
                    echo json_encode($data);
                }
                else{
                    $data['error_msg']='<p>Imagen Seleccionada no valida o vacía</p>';
                    echo json_encode($data);
                }
            }
            else{
                //estado_img = 1 ->Edit contiene imagen
                //estado_img = 2 ->Edit No contiene imagen
                if ($post_xss['estado_img']==1) {
                    $name=$this->GuardarImagen();
                    if ($name!="") {
                        $this->EliminarImagem($post_xss);
                        $url=base_url('/uploads/').$name;
                    }
                    else{
                        $data['error_msg']='<p>Imagen Seleccionada no valida o vacía</p>';
                        echo json_encode($data);
                        return;
                    }
                }
                else{
                    $url=$post_xss['url_img'];
                }
                $data=$this->ArmarObjeto($post_xss,$url);
                echo json_encode($data);
            }
        }
        else{
            $data['error_msg'] = validation_errors();
            echo json_encode($data);
        }
    }

    public function EliminarRegistroImagen()
    {
        $post_xss=$this->input->post(NULL, TRUE);
        $this->EliminarImagem($post_xss);
        echo 'ok';
    }

    public function ArmarObjeto($post_xss,$url)
    {
        $data["imagen"]=$url;
        $data["desde"]=$post_xss["desde"];
        $data["hasta"]=$post_xss["hasta"];
        $data["inicio"]=$post_xss["inicio"];
        $data["fin"]=$post_xss["fin"];
        $data["estado"]=$post_xss["estado"];
        $data["link"]=$post_xss["link"];
        $data["extension"]=$post_xss["extension"];
        $data["banner"]=$post_xss["banner"];
        $data["promocion"]=$post_xss["promocion"];
        $data["prioridad"]=(int)$post_xss["prioridad"];
        return $data;
    }

    public function EliminarImagem($post_xss)
    {
        if ($post_xss['tipo']==2) {
            $particion=explode('_', $post_xss['url_img']);
            if (count($particion)>1) {
                $link='uploads/imgen_'.$particion[1];
                if (is_readable($link)) {
                    unlink($link);
                }
            }
        }
    }

    public function GuardarImagen()
    {
        $name="imgen_".time();
        $mi_archivo = 'imagen';
        $config['upload_path'] = "./uploads/";
        $config['file_name'] = $name;
        $config['allowed_types'] = "jpeg|jpg|png";
        $config['max_size'] = "50000";

        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload($mi_archivo)) {
            return '';
        }
        else{
            return $this->upload->data()["file_name"];
        }
    }

    public function Promociones()
    {
        $this->template->add_js('js/ckeditor/ckeditor.js',1);
        $this->template->add_js('js/moment/moment.min.js');
        $this->template->add_js('https://www.starperu.com/es/js/starperu/starperu.js',1);
        $this->template->add_js('https://www.starperu.com/es/js/starperu/star_promocion.js',1);
        $this->template->add_js('js/starperu/promocion.js',1);
        $this->template->set("titulo", "Promociones");
        $this->template->load(150, 'starperu/v_promociones');
    }

    public function GuardarPromocion()
    {
        // echo $_GET['datajson'];
        $objstar='datajson='.$_POST['datajson'];
        crear_objeto_js($objstar,'star_promocion');
        echo "ok";
    }

    /*
    ** FUNCIONES PARA RESTABLECER LAS CONDICIONES DE LAS FAMILIAS 
    */
    public function ObtenerFamilias()
    {
        $familias=Familia_Model::get();
        $data['familias']=$familias;
        $this->template->add_css('css/web/familia.css',1);
        $this->template->add_js('js/starperu/familias.js',1);
        $this->template->set("titulo", "Familias");
        $this->template->load(150, 'starperu/v_familias',$data);
    }

    public function GuardarCondicion()
    {
        $condiciones=$_POST['condiciones'];
        $codigo=$_POST['codigo'];
        $familia=Familia_Model::find($codigo);
        $familia->condiciones=$condiciones;
        $familia->save();
        echo 'ok';
    }

}
