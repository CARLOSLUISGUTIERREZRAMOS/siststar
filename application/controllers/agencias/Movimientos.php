<?php
use Models\agencias\Entidad_Model;
use Models\agencias\Personal_Model;
class Movimientos extends CI_Controller {
	public function __construct() {
        parent::__construct();
        isset($this->session->username) ? TRUE : header('Location: '.base_url());
        $this->load->helper('logsystemweb');
        $this->load->helper('funciones_generales');
        $this->load->helper('fechasHoras');
        $this->load->helper('email');
        $this->load->library('form_validation');
        $this->load->library('kiu/Agencias/Connection_kiu');
        $this->load->library('kiu/Agencias/Model_kiu');
        $this->load->library('kiu/Agencias/Controller_kiu');

        $this->load->model('agencias/Movimientos_Model');
        $this->template->add_css('css/toastr/toastr.css');
        $this->template->add_js('js/toastr/toastr.js');
    }

    public function index()
    {

        $this->template->set("titulo", "REPORTE DE MOVIMIENTOS");
        $this->template->add_css('css/bootstrap-datepicker/bootstrap-datepicker3.css');
        $this->template->add_css('css/agencia/movimientos.css',1);
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.js');
        $this->template->add_js('js/bootstrap-datepicker/bootstrap-datepicker.es.min.js');
        $this->template->add_js('js/agencias/movimientos.js',1);
        
        $desde=$this->session->s_desde ? $this->session->s_desde : date('Y-m-d');
        $hasta=$this->session->s_hasta ? $this->session->s_hasta : date('Y-m-d');
        $select=$this->session->s_select ? $this->session->s_select : 0;
        $rows=$this->session->s_rows ? $this->session->s_rows : '';
        $page=$this->session->s_page ? $this->session->s_page : '';
        $apellido=$this->session->s_apellido ? $this->session->s_apellido : '';
        $ruc=$this->session->s_ruc ? $this->session->s_ruc : '';
        $pnr=$this->session->s_pnr ? $this->session->s_pnr : '';
        $estado=$this->session->s_estado !='' ? $this->session->s_estado : '';
        $forma_pago=$this->session->s_forma_pago !='' ? $this->session->s_forma_pago : '';
        $data=$this->GetMovimientos($desde,$hasta,$select,$rows,$page,$apellido,$ruc,$pnr,$estado);
        // dd($data['movimientos']);
        $this->template->load(160,'agencias/movimientos/v_movimiento',$data);
    }

    public function GetMovimientos($desde,$hasta,$select,$rows=null,$page=null,$apellido=null,$ruc=null,$pnr=null,$estado=null,$forma_pago=null)
    {
        if (!empty($apellido) || !empty($ruc) || !empty($pnr)) {
            $condicion=0;
        }
        else{
            $condicion=1;
        }

        $rows=(int)($rows ? $rows : 20);
        if ($select==1) {
            $page=1;
        }
        else{
            $page=(int)($page ? $page : 1);
        }
        $current = ($page-1)*$rows;
        // dd(empty('0'));

        $consulta=$this->Movimientos_Model->GetMovimientos($desde,$hasta,$apellido,$ruc,$pnr,$estado,$forma_pago,$condicion);
        $data=$this->Movimientos_Model->GetDataConsultaLimit($consulta,$current,$rows);
        // dd($data);
        $total_rows=$this->Movimientos_Model->GetCount($consulta);
        $totales=$this->Movimientos_Model->GetTotalesMovimiento($consulta);
        $paginacion=$this->getPaginationString($page,$total_rows,$rows);

        $li=ceil($total_rows/$rows);
        $config['total_columnas']=$li;
        $config['total_rows']=$total_rows;
        $config['rows']=$rows;
        $config['page']=$page;
        $config['current']=$current;


        $objeto['movimientos']=$data;
        $objeto['totales']=$totales;
        $objeto['config']=(object)$config;
        $objeto['paginacion']=$paginacion;
        return $objeto;
    }

    public function BusquedaMovimientos()
    {
        $xss_post = (object)$this->input->post(NULL, TRUE);
        $this->session->set_userdata('s_desde',fecha_iso_8601($xss_post->fecha_desde));
        $this->session->set_userdata('s_hasta',fecha_iso_8601($xss_post->fecha_hasta));
        $this->session->set_userdata('s_select',$xss_post->select);
        $this->session->set_userdata('s_rows',$xss_post->mostrar);
        $this->session->set_userdata('s_page',$xss_post->page);
        $this->session->set_userdata('s_apellido',$xss_post->apellido);
        $this->session->set_userdata('s_ruc',$xss_post->ruc);
        $this->session->set_userdata('s_pnr',$xss_post->pnr);
        $this->session->set_userdata('s_estado',$xss_post->estado);
        $this->session->set_userdata('s_forma_pago',$xss_post->forma_pago);

        $desde=fecha_iso_8601($xss_post->fecha_desde);
        $hasta=fecha_iso_8601($xss_post->fecha_hasta);
        $data=$this->GetMovimientos($desde,$hasta,$xss_post->select,$xss_post->mostrar,$xss_post->page,$xss_post->apellido,$xss_post->ruc,$xss_post->pnr,$xss_post->estado,$xss_post->forma_pago);
        $view=$this->load->view('agencias/movimientos/v_contenido_movimiento',$data,TRUE);
        echo $view;
    }

    public function ObtenerEticket($ticket) {
        $mensaje_error='';
        if(isset($ticket)){
            $args = array(
                "IdTicket" => $ticket,
                "CodReserva" => ''
            );
            $res_ticket = $this->controller_kiu->TravelItineraryReadRQ($args,$err);

            if(isset($res_ticket['Error']['ErrorMsg'])){
                 /*MOSTRAR PANTALLA DE ERROR*/
                $mensaje_error=$res_ticket['Error']['ErrorMsg'];
            }
            else{
                $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"] = str_replace('cid:imagen_324', base_url().'img/LogoStar.png', $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"]);

                if(count($res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"])==0){
                  $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"]='NÚMERO DE TICKET INVÁLIDO, EL TICKET HA SIDO ANULADO./ INVALID TICKET NUMBER';
                }
            }
        }
        else{
            $mensaje_error='NO SE HA GENERADO EL TICKET';
        }
        
        if($mensaje_error!=''):
            echo $mensaje_error;
        else:
            $res = $res_ticket["ItineraryInfo"]["Ticketing"]["TicketAdvisory"];
            echo $res;
        endif;
    }

    public function ObtenerDetalleTransaccion($reserva) {
        $array = $this->Movimientos_Model->ObtenerReserva($reserva);
        $xss_post = (object)$this->input->post(NULL, TRUE);
        $array['ticket']=$xss_post->ticket;
        $array['detalle']=$xss_post->detalle;
        $array['registro']=$xss_post->registro;
        // dd($array);
        $view=$this->load->view('agencias/movimientos/v_detalle_transaccion',$array,TRUE);
        echo $view;
    }

    public function ObtenerDetalleTransaccionVisa()
    {
        $reserva_id=$_POST['reserva_id'];
        $data['visas'] = $this->Movimientos_Model->ObtenerVisa($reserva_id);
        $view=$this->load->view('agencias/movimientos/v_detalle_visa',$data,TRUE);
        echo $view;
    }

    public function getPaginationString($page = 1, $totalitems, $limit = 15)
    {       
        //defaults
        $adjacents = 1;
        if(!$limit) $limit = 15;
        if(!$page) $page = 1;
        
        //other vars
        $prev = $page - 1;                                  //previous page is page - 1
        $next = $page + 1;                                  //next page is page + 1
        $lastpage = ceil($totalitems / $limit);             //lastpage is = total items / items per page, rounded up.
        $lpm1 = $lastpage - 1;                              //last page minus 1
        /* 
            Now we apply our rules and draw the pagination object. 
            We're actually saving the code to a variable in case we want to draw it more than once.
        */
        $pagination = '';
        if($lastpage > 1){   
            $pagination .= '<ul class="pagination">';

            //previous button
            if ($page > 1) 
                $disabled= '';
            else
                $disabled= 'disabled';
            
            $pagination .= '<li class="page-item '.$disabled.'">
                                <a href="javascript:cambiarPaginacion('.$prev.');" class="page-link">
                                    <span aria-hidden="true">Antes</span>
                                </a>
                            </li>';
            
            //pages 
            if ($lastpage < 7 + ($adjacents * 2)){   //not enough pages to bother breaking it up
                for ($counter = 1; $counter <= $lastpage; $counter++){
                    if ($counter == $page){
                        $active='active';
                        $href  = '<span>'.$counter.'</span>';
                    }
                    else{
                        $active='';
                        $href ='<a href="javascript:cambiarPaginacion('.$counter.');" class="page-link">'
                                    .$counter.
                                '</a>';
                    }
                    $pagination.='<li class="page-item '.$active.'">'.$href.'</li>';
                }
            }
            elseif($lastpage >= 7 + ($adjacents * 2)){   //enough pages to hide some
                //cerca de empezar solo ocultar páginas posteriores
                if($page < 1 + ($adjacents * 3)){
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                        if ($counter == $page){
                            $active='active';
                            $href  = '<span>'.$counter.'</span>';
                        }
                        else{
                            $active='';
                            $href  ='<a href="javascript:cambiarPaginacion('.$counter.');" class="page-link">'
                                        .$counter.
                                    '</a>';
                        }
                        $pagination.='<li class="page-item '.$active.'">'.$href.'</li>';
                    }
                    $pagination .= '<li class="page-item"><span class="elipses">...</span></li>';
                    $pagination .= '<li class="page-item">
                                        <a href="javascript:cambiarPaginacion('.$lpm1.');" class="page-link">'
                                            .$lpm1.
                                        '</a>
                                    </li>';
                    $pagination .= '<li class="page-item">
                                        <a href="javascript:cambiarPaginacion('.$lastpage.');" class="page-link">'
                                            .$lastpage.
                                        '</a>
                                    </li>';
                }
                //en medio esconder algún frente y otro atrás
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                    $pagination .= '<li class="page-item">
                                        <a href="javascript:cambiarPaginacion(1);" class="page-link">1</a>
                                    </li>';
                    $pagination .= '<li class="page-item">
                                        <a href="javascript:cambiarPaginacion(2);" class="page-link">2</a>
                                    </li>';
                    $pagination .= '<li class="page-item"><span class="elipses">...</span></li>';
                    
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                        if ($counter == $page){
                            $active='active';
                            $href = '<span>'.$counter.'</span>';
                        }
                        else{
                            $active='';
                            $href  ='<a href="javascript:cambiarPaginacion('.$counter.');" class="page-link">'
                                        .$counter.
                                    '</a>';
                        }
                        $pagination.='<li class="page-item '.$active.'">'.$href.'</li>';
                    }
                    
                    $pagination .= '<li class="page-item"><span class="elipses">...</span></li>';
                    $pagination .= '<li class="page-item">
                                        <a href="javascript:cambiarPaginacion('.$lpm1.');" class="page-link">'
                                            .$lpm1.
                                        '</a>
                                    </li>';
                    $pagination .= '<li class="page-item">
                                        <a href="javascript:cambiarPaginacion('.$lastpage.');" class="page-link">'
                                            .$lastpage.
                                        '</a>
                                    </li>';
                }
                //cerca de fin solo ocultar las primeras páginas
                else{
                    $pagination .= '<li class="page-item">
                                        <a href="javascript:cambiarPaginacion(1);" class="page-link">1</a>
                                    </li>';
                    $pagination .= '<li class="page-item">
                                        <a href="javascript:cambiarPaginacion(2);" class="page-link">2</a>
                                    </li>';
                    $pagination .= '<li class="page-item"><span class="elipses">...</span></li>';
                    for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++){
                        if ($counter == $page){
                            $active='active';
                            $href = '<span>'.$counter.'</span>';
                        }
                        else{
                            $active='';
                            $href  ='<a href="javascript:cambiarPaginacion('.$counter.');" class="page-link">'
                                        .$counter.
                                    '</a>';
                        }
                        $pagination.='<li class="page-item '.$active.'">'.$href.'</li>';
                    }
                }
            }
            
            //next button
            if ($page < $counter - 1) 
                $disabled= '';
            else
                $disabled= 'disabled';
            
            $pagination .= '<li class="page-item '.$disabled.'">
                                <a href="javascript:cambiarPaginacion('.$next.');" class="page-link">
                                    <span aria-hidden="true">Sig.</span>
                                </a>
                            </li>';

            $pagination .= '</ul>';
        }
        
        return $pagination;

    }

}