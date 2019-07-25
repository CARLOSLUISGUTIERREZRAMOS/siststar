<?php

if (!defined('BASEPATH'))
    exit('No permitir el acceso directo al script');

class Usuario_Model extends CI_Model {

    private $id_usuario;
    private $nombre;
    private $apellido;
    private $nombre_cargo;
    private $id_rol;
    private $email;

    public function __construct() {
        parent::__construct();
        $this->load->library('Seguridad/Password');
    }

    public function registra($data) {
        $res = $this->db->insert('usuario', $data);
        if ($res == FALSE) {
            return $this->db->error();
        } else {
            return $res;
        }
    }

    public function ActivaDesactUsuario($codUsuario = NULL, $CharAccion, $id_usuario = NULL) {
        $data = array('estado' => "$CharAccion");
        if (!is_null($id_usuario)) {
            $this->db->where('id_usuario', $id_usuario);
        } else {
            $this->db->where('codigo', $codUsuario);
        }
        $this->db->update('usuario', $data);
    }

    public function verificaUsuario($codigoUsuario) {

        $query = $this->db->get_where('usuario', array('codigo' => $codigoUsuario, 'estado' => 'Y'), 1);
        return (bool) $query->num_rows();
    }

    public function verificaUsuarioAgente_sqlserver($codagente_post) {

        $query = "SELECT TOP 1 Codigo FROM Agentes WHERE Codigo = $codagente_post";
        $resultado = $this->connection_sqlserver->getConexion()->Execute($query);
        return $resultado;
    }

    public function validaPassword($codUser, $pass) {

        $this->db->select('pass');
        return $this->db->get_where('usuario', array('codigo' => $codUser))->row()->pass;
    }

    public function createObjUser($codUsuario) {

        $this->db->select('id_usuario,nombre,apellido,cargo.nombre_cargo,id_rol,email');
        $this->db->join('cargo', 'usuario.id_cargo = cargo.id_cargo');
        $res = $this->db->get_where('usuario', array('codigo' => $codUsuario), 1);
        foreach ($res->result() as $user) {
            $this->id_usuario = $user->id_usuario;
            $this->nombre = $user->nombre;
            $this->apellido = $user->apellido;
            $this->nombre_cargo = $user->nombre_cargo;
            $this->id_rol = $user->id_rol;
            $this->email = $user->email;
        }
    }

    public function createObjUserAgente($codAgente) {
        $query = "SELECT TOP 1 * FROM Agentes WHERE Codigo = $codAgente";
        $resultado = $this->connection_sqlserver->getConexion()->Execute($query);
        return $resultado;
    }

    public function ListaUsuarios() {
        $query = $this->db->get('usuario');
        return $query;
    }

    public function GetUsuarios_in($id_usuarios) {
        $this->db->select('id_usuario,email,nombre,apellido');
        $this->db->from('usuario');
        $where = "id_usuario IN($id_usuarios)";
        $this->db->where($where);
        $this->db->where('estado', 'Y');
        $query = $this->db->get();

        return $query;
    }

    function GetDataUsuario($id) {

        $this->db->select('email');
        $where = "id_usuario IN($id)";
        return $this->db->get_where('usuario', $where)->row()->email;
    }

    public function getEstado($id) {
        $this->db->select('estado');
        $res = $this->db->get_where('usuario', array('id_usuario' => $id), 1)->row()->estado;

        return $res;
    }

    public function getRoles()
    {
    	$this->db->select('*');
    	$this->db->from('rol');
    	$this->db->where('estado','Y');
    	$query = $this->db->get();
        return $query;
    }

    public function getCargos()
    {
    	$this->db->select('*');
    	$this->db->from('cargo');
    	$this->db->where('estado','Y');
    	$query = $this->db->get();
        return $query;
    }

    public function getCiudades()
    {
    	$this->db->select('*');
    	$this->db->from('ciudad');
    	$this->db->where('estado','Y');
    	$query = $this->db->get();
        return $query;
    }

    public function getAreaTrabajos()
    {
    	$this->db->select('*');
    	$this->db->from('area_trabajo');
    	$this->db->where('estado','Y');
    	$query = $this->db->get();
        return $query;
    }

    //<editor-fold desc="METODOS GET" defaultstate="collapsed">
    function getId_usuario() {
        return $this->id_usuario;
    }

    function getNombre() {
        return $this->nombre;
//        $this->db->select('codigo');
//        return $this->db->get_where('usuario', array('id_usuario' => $id_usuario), 1)->row()->codigo;
    }

    function getApellido() {
        return $this->apellido;
    }

    function getNombre_cargo() {
        return $this->nombre_cargo;
    }

    function getId_rol() {
        return $this->id_rol;
    }

    function getEmail() {
        return $this->email;
    }

    //</editor-fold>
}
