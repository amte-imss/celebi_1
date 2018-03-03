<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Docente extends Control_escolar
{

  function __construct()
  {
      parent::__construct();
      $this->load->model('Profesores_model', 'docente');
      $this->tipo_participante = Control_escolar::PROFESOR;
  }

  public function registro()
  {
      
  }

  public function profesores_implementacion_view($id_implementacion)
  {
  	$this->load->model('Implementaciones_model', 'implementaciones');
  	$this->load->model('Catalogo_model', 'catalogo');

  	$this->template->setTitle('Control escolar');
  	$data = array();
  	$data['etapa'] = 'ultima';

    $data['id_implementacion'] = $id_implementacion;

  	$implementacion = $this->implementaciones->get_implementacion(array('i.id_implementacion' => $id_implementacion));
  	$data['regla'] = $this->catalogo->get_reglas_tipo_curso(array('id_regla_tipo_curso' => $implementacion[0]['id_regla_tipo_curso']))[0];

  	$main_content = $this->load->view('/implementaciones/profesores.php', $data, TRUE);
      $this->template->setMainContent($main_content);
      $this->template->getTemplate();
  }

  public function profesores_implementacion($id_implementacion){
      $this->load->model('Implementaciones_model', 'implementaciones');

      $resultado = array();
      $titulares = array();
      $adjuntos = array();

      $participantes = $this->implementaciones->get_participantes(array('id_implementacion' => $id_implementacion,'i.id_rol_participante <' => '3'));
      foreach ($participantes as $key => $value) {
        $p = $value['id_participante'];
        if(!is_null($p) || $p != ''){
          $select = array('matricula','nombre_siap','apellido_paterno_siap','apellido_materno_siap','curp','d.nombre delegacion','clave_delegacion', 'correo_electronico');
          $profesor = $this->docente->get_profesor(array('id_participante'=>$p),$select)[0];
          $profesor['nombre_participante'] = $profesor['nombre_siap'].' '.$profesor['apellido_paterno_siap'].' '.$profesor['apellido_materno_siap'];
        }else{
          $profesor = array(
            'matricula' => null,
            'nombre_participante' => null,
            'curp' => null,
            'delegacion' => null,
            'correo_electronico' => null
            );
        }
        $datos_prof = array_merge($value,$profesor);

        if($value['id_rol_participante'] == 1)
          array_push($titulares,$datos_prof);
        else
          array_push($adjuntos,$datos_prof);

        //$resultado['data'] = $participantes;
        $resultado['titulares'] = $titulares;
        $resultado['adjuntos'] = $adjuntos;
      }
  	header('Content-Type: application/json; charset=utf-8;');
      echo json_encode($resultado);
  }

  public function profesor_titular($matricula)
  {
    if(!is_null($matricula))
    {
      if (strlen($matricula) > 15)
      {
          $resultado = array("success" => false, "message" => "La matrícula no debe de tener más de 15 caracteres", "data" => []);
      } else
      {
          $select = array('matricula','nombre_siap','apellido_paterno_siap','apellido_materno_siap','curp','d.nombre delegacion','clave_delegacion', 'correo_electronico');
          $profesor = $this->docente->get_profesor(array('matricula'=>$matricula,'is_ciefd'=>true),$select);

          if (count($profesor) < 1)
          {
              $resultado = array("success" => false, "message" => "No se ha encontrado la matrícula " . $matricula . ". Favor de verificar.");
          } else
          {
              $profesor = $profesor[0];
              $profesor['nombre_participante'] = $profesor['nombre_siap'].' '.$profesor['apellido_paterno_siap'].' '.$profesor['apellido_materno_siap'];
              $resultado = array("success" => true, "message" => "Se encontro la información en nómina asociada a la matrícula " . $matricula, "data" => $profesor);
          }
      }

      header('Content-Type: application/json; charset=utf-8;');
      echo json_encode($resultado);
    }
  }


  public function profesor_adjunto($matricula, $delegacion=null)
  {
    if(!is_null($matricula))
    {
      if (strlen($matricula) > 15)
      {
          $resultado = array("success" => false, "message" => "La matrícula no debe de tener más de 15 caracteres", "data" => []);
      } else
      {
          $select = array('matricula','nombre_siap','apellido_paterno_siap','apellido_materno_siap','curp','d.nombre delegacion','clave_delegacion', 'correo_electronico');
          $profesor = $this->docente->get_profesor(array('matricula'=>$matricula),$select);

          if (count($profesor) < 1)
          {
              $profesor = $this->docente->get_profesor_nomina(array('matricula'=>$matricula),$select);
              $resultado = array("success" => false, "message" => "No se ha encontrado la matrícula " . $matricula . ". Favor de verificar.");
          } else
          {
              $profesor = $profesor[0];
              $profesor['nombre_participante'] = $profesor['nombre_siap'].' '.$profesor['apellido_paterno_siap'].' '.$profesor['apellido_materno_siap'];
              $resultado = array("success" => true, "message" => "Se encontro la información en nómina asociada a la matrícula " . $matricula, "data" => $profesor);
          }
      }

      header('Content-Type: application/json; charset=utf-8;');
      echo json_encode($resultado);
    }
  } 
}
