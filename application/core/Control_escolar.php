<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author: LEAS
 * @version: 1.0
 * @desc: Exclusivo sistema control escolar
 * */
class Control_escolar extends MY_Controller
{

    /**
     *
     * @var type INT: controlador o participante, tipo de participante, ALumno o profesor
     */
    protected $tipo_participante;

    const ALUMNO = 2,
            PROFESOR = 1,
            AMBOS = 3
    ;
    const LISTA = 'lista';
    const EDITAR = 'editar';
    const INSERTAR = 'insertar';
    const ELIMINAR = 'eliminar';

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//        echo "Hola sobre escribe el index";
        $this->template->setTitle('Control escolar');
        $main_content = 'Hola, genera tu propio index';
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    protected function get_participantes($implementacion)
    {
        switch ($this->tipo_participante)
        {
            case Control_escolar::PROFESOR:
                break;
            case Control_escolar::ALUMNO:
                break;
        }
    }

    protected function get_detalle_participantes($implementacion, $id_participante)
    {
        switch ($this->tipo_participante)
        {
            case Control_escolar::PROFESOR:
                break;
            case Control_escolar::ALUMNO:
                break;
        }
    }

    public function activo($implementacion, $id_participante)
    {
        
    }

    public function constancia($implementacion, $id_participante)
    {
        
    }

    public function exportar($id_participante)
    {
        switch ($this->tipo_participante)
        {
            case Control_escolar::PROFESOR:
                break;
            case Control_escolar::ALUMNO:
                break;
        }
    }

}
