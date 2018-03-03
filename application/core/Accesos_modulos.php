<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author: LEAS
 * @version: 1.0
 * @desc: Interface que implementa control de accesos y datos de la sesión
 * */
interface Accesos_modulos
{

    
    /**
     * @author LEAS
     * @fecha 15/02/2018
     * @description Obtiene array con los accesos del sistema
     */
    public function get_accesos();

    /**
     * @author LEAS
     * @fecha 15/02/2018
     * @description Asigna los accesos del sistema
     */
    public function set_accesos($accesos);

    
    public function is_acceso($niveles_requeridos = array(), $niveles_disponibles = array());

    /**
     * @author LEAS
     * 
     * @param type $busqueda_especifica
     * @return int
     * @obtiene el array de los datos de session
     */
    public function get_datos_sesion($busqueda_especifica = '*');
}
