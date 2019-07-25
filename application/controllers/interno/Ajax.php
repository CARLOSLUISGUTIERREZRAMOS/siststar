<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        echo isset($this->session->username) ? 1 : 0;
    }
}
