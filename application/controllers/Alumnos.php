<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos extends Control_escolar
{

    function __construct()
    {
        parent::__construct();
//        $this->load->model('Alumnos_model', 'alumnos');
        $this->tipo_participante = Control_escolar::ALUMNO;
    }

    public function registro()
    {
        
    }

}
