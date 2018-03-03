<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cursos extends Control_escolar

{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('grocery_CRUD');
//        $this->load->model('Cursos_model', 'cursos');
    $this->load->library('form_complete');
  }

  public function index()
  {
    try{
      $data_view = array();

      $this->db->schema = 'presenciales';
      $crud = $this->new_crud();
      $crud->set_table('curso');
      $crud->set_subject('cursos');
      $crud->set_primary_key('clave_curso');
      $crud->set_relation('id_tipo_curso','tipo_curso','nombre');
      
      $crud->columns('clave_curso','nombre','id_tipo_curso','anio','activo');
      $crud->fields('clave_curso','nombre','id_tipo_curso','anio','activo');
      
      $crud->required_fields('clave_curso','nombre','anio','id_tipo_curso');
      
      $crud->display_as('clave_curso','Clave de curso');
      $crud->display_as('id_tipo_curso','Tipo de curso');
      $crud->display_as('anio','Año');

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

  public function cursos()
  {
    # code...
  }

  public function exportar_listado()
  {
      
  }

  protected function get_detalle_curso($curso)
  {
      
  }

  protected function get_listado_curso()
  {
      
  }

}
