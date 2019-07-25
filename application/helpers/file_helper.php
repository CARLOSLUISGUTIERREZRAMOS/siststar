<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function validaTipoExcel($typeFile) {
    $bool = ($typeFile == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') ? true : false;
    return $bool;
}