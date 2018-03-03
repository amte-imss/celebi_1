<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cursos_model extends MY_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
    
    /**
    * Devuelve un arreglo con toda la información de los cursos registrados
    * @author CPMS
    * @date 26/02/2018
    * @param arreglo comn los filtros a la busqueda
    * @return array
    */
    public function get_cursos($filtros)
    {
        
    }

    public function update_cursos($filtros, $datos)
    {
        
    }

    public function insert_cursos($datos)
    {
        
    }

}
