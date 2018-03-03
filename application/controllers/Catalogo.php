<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo extends MY_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->database();
      $this->load->library('grocery_CRUD');
      $this->load->model('catalogo_model', 'catalogo');
      $this->load->library('form_complete');
    }


    public function index()
    {
    }

    public function get_delegaciones()
    {
        $resultado = $this->catalogo->get_delegaciones();
        header('Content-Type: application/json; charset=utf-8;');
        echo json_encode($resultado);
    }

    public function tipo_curso()
    {
      try{
        $data_view = array();

        $this->db->schema = 'presenciales';
        $crud = $this->new_crud();
        $crud->set_table('tipo_curso');
        $crud->set_subject('tipo de curso');
        $crud->set_primary_key('id_tipo_curso');

        $crud->columns('id_tipo_curso','nombre','activo','descripcion');
        $crud->fields('nombre','activo','descripcion');

        $crud->required_fields('nombre');

        $crud->display_as('id_tipo_curso','Id');
        $crud->display_as('descripcion','Descripción');

        $crud->change_field_type('activo', 'true_false', array(0 => 'No', 1 => 'Si'));

        $crud->unset_texteditor('descripcion','full_text');
        $crud->unset_read();
        $crud->unset_delete();

        $data_view['output'] = $crud->render();

        $vista = $this->load->view('catalogo/admin.tpl.php', $data_view, true);
        $this->template->setMainContent($vista);
        $this->template->getTemplate();
        
      } catch (Exception $e) {
        show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
      }
    }

    public function reglas_tipo_curso()
    {
      try{
        $data_view = array();

        $this->db->schema = 'presenciales';
        $crud = $this->new_crud();
        $crud->set_table('reglas_tipo_curso');
        $crud->set_subject('regla para los tipos de curso');
        $crud->set_primary_key('id_regla_tipo_curso');
        $crud->set_relation('id_tipo_curso','tipo_curso','nombre');
        
        $crud->columns('id_tipo_curso','num_profesores_titulares','num_profesores_adjuntos','cupo_min_alumnos','cupo_max_alumnos','horas_max','horas_min','activo');
        $crud->fields('id_tipo_curso','num_profesores_titulares','num_profesores_adjuntos','cupo_min_alumnos','cupo_max_alumnos','horas_max','horas_min','activo');
        
        $crud->required_fields('id_tipo_curso','num_profesores_titulares','num_profesores_adjuntos','cupo_min_alumnos','cupo_max_alumnos');
        
        $crud->display_as('id_tipo_curso','Tipo de curso');
        $crud->display_as('cve_reglas_tipo_curso','id');
        $crud->display_as('num_profesores_adjuntos','# adjuntos');
        $crud->display_as('num_profesores_titulares','# titulares');
        $crud->display_as('horas_maximas','# horas máximas');
        $crud->display_as('horas_minimas','# horas mínimas');
        $crud->display_as('cupo_max_alumnos','# cupo máximo');
        $crud->display_as('cupo_min_alumnos','# cupo mínimo');

        $crud->change_field_type('activo', 'true_false', array(0 => 'No', 1 => 'Si'));

        $crud->unset_delete();
        $crud->unset_read();
        
        $data_view['output'] = $crud->render();

        $vista = $this->load->view('catalogo/admin.tpl.php', $data_view, true);
        $this->template->setMainContent($vista);
        $this->template->getTemplate();
        
      } catch (Exception $e) {
        show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
      }
    
    }

}

?>