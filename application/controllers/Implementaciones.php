<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include(APPPATH . 'controllers/Cursos.php');

class Implementaciones extends Cursos
{

    const ET_DATOS_GENERALES = 1,
            ET_PROFESORES = 2,
            ET_PROGRAMACION = 3,
            ET_ALUMNOS = 4;

    private $etapas = array();

    function __construct()
    {
        parent::__construct();
        $this->load->model('Implementaciones_model', 'imp');
        $this->load->model('Catalogo_model', 'cat');
        $this->load->library('Form_complete');
        $this->tipo_participante = Control_escolar::AMBOS;
        $this->inicializa();
    }

    private function inicializa()
    {

        $this->etapas = array(
            Implementaciones::ET_DATOS_GENERALES => ['vista' => 'implementaciones/datos_generales.php',
                'catalogos' => [
                    'curso' => [
                        'cargar_iniciar' => true,
                        'nombre_tabla' => 'presenciales.curso',
                        'key' => 'clave_curso',
                        'value' => 'nombre',
                        'enviar_objeto' => true,
                        'select' => ["clave_curso", "nombre", "id_tipo_curso"],
                        'where' => ['activo' => TRUE]
                    ],
                    'tipo_curso' => [
                        'cargar_iniciar' => true,
                        'nombre_tabla' => 'presenciales.tipo_curso',
                        'key' => 'id_tipo_curso',
                        'value' => 'nombre',
                        'enviar_objeto' => true,
                        'select' => ["id_tipo_curso", "nombre"],
                        'where' => ['activo' => TRUE],
                        'rules' => ['required'],
                    ],
                    'reglas_tipo_curso' => [
                        'cargar_iniciar' => true,
                        'nombre_tabla' => 'presenciales.reglas_tipo_curso',
                        'key' => 'id_regla_tipo_curso',
                        'value' => 'cupo_min_max',
                        'enviar_objeto' => true,
                        'select' => ["id_regla_tipo_curso", "concat(cupo_min_alumnos, ' - ', cupo_max_alumnos) cupo_min_max", "id_tipo_curso", "num_profesores_titulares", "num_profesores_adjuntos", "horas_max", "horas_min", "cupo_min_alumnos", "cupo_max_alumnos"],
                        'where' => ['activo' => TRUE]
                    ],
                    'categoria_convocada' => [
                        'cargar_iniciar' => true,
                        'nombre_tabla' => 'presenciales.categoria_convocada',
                        'key' => 'id_categoria',
                        'value' => 'nombre',
                        'enviar_objeto' => FALSE,
                        'select' => ["id_categoria", "nombre", "id_categoria_padre"],
                        'where' => ['activo' => TRUE]
                    ],
                    'sede' => [
                        'cargar_iniciar' => true,
                        'nombre_tabla' => 'catalogo.unidades_instituto u',
                        'key' => 'clave_unidad',
                        'value' => 'nombre',
                        'enviar_objeto' => FALSE,
                        'select' => ["u.id_unidad_instituto", "u.nombre", "clave_unidad"],
                        'where' => ['u.activa' => TRUE, 'tu.nombre' => 'HGO'],
                        'join' => array(
                            ['table' => 'catalogo.tipos_unidades tu', 'condition' => 'tu.id_tipo_unidad = u.id_unidad_instituto', 'type' => 'inner']
                        )
                    ],
                ],
            ],
            Implementaciones::ET_PROFESORES => ['vista' => 'implementaciones/profesores.php',
                'catalogos' => ['' => []
                ],
            ],
            Implementaciones::ET_PROGRAMACION => ['vista' => 'implementaciones/programacion.php',
                'catalogos' => ['' => []
                ],
            ],
            Implementaciones::ET_ALUMNOS => ['vista' => 'implementaciones/alumnos.php',
                'catalogos' => ['' => []
                ],
            ],
        );
    }

    public function index()
    {
        $this->template->setTitle('Control escolar');
        $datos_wizard = [];
        foreach ($this->etapas as $key_etapa => $value)
        {
            $catalogos = $this->get_catalogos($value['catalogos']); //Obtiene los catálogos de la vista
//            pr($catalogos);
            $datos_wizard['step' . $key_etapa] = $this->load->view($value['vista'], ['etapa' => $key_etapa, 'catalogos' => $catalogos,], true); //
        }
//        $etapas['etapas'] = $this->load->view('/implementaciones/wizard_etapas.php', $datos_wizard, TRUE);
        $etapas['etapas'] = "Nada";
        $data['vista_implementacion'] = $this->load->view('/implementaciones/vista_implementacion.php', $etapas, TRUE);
        $main_content = $this->load->view('/implementaciones/implementaciones.tpl.php', $data, TRUE);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    private function get_catalogos($catalogos = array())
    {
        $result = array();
        foreach ($catalogos as $key => $value)
        {
            if (!empty($value) && $value['cargar_iniciar'])
            {
//                pr($value);
                $result[$key]['key'] = $value['key'];
                $result[$key]['value'] = $value['value'];
                $result[$key]['opciones'] = $this->cat->get_registros($value['nombre_tabla'], $value);
                $result[$key]['enviar_objeto'] = $value['enviar_objeto'];
            }
        }
        return $result;
    }

    public function listado()
    {
//    LNiveles_acceso::Profesionalizacion;
//    switch ()
//        if ($this->input->is_ajax_request())
//        {
        $result['data'] = $this->imp->get_listado_implementacion();
        $result['estados_implementaciones'] = $this->cat->get_estados_implementacion();
        $return = json_encode($result);
        echo $return;
//        }
    }

    public function registro()
    {
        $post = $this->input->post(null, true);
        switch ($post['etapa'])
        {
            case Implementaciones::ET_PROFESORES:
                $return = $this->insertupdate_profesores($post);
                break;
            case Implementaciones::ET_PROGRAMACION:
                $return = $this->insertupdate_programacion($post);
                break;
            case Implementaciones::ET_ALUMNOS:
                $return = $this->insertupdate_alumnos($post);
                break;
            case Implementaciones::ET_DATOS_GENERALES://Implementaciones::ET_DATOS_GENERALES
                $return = $return = $this->insertupdate_datos_generales($post);
        }
    }

    /**
     * 
     * @author LEAS
     * @fecha 26/02/2018
     * @param type $post
     */
    private function insertupdate_datos_generales($post)
    {
        $msj = ['success' => 'El registro fue gusrdado correctamente', 'danger' => 'No fue posible guardar los datos. Por favor intentalo más tarde'];
        $convocatoria = [];
        $aux_post = $post;
        $is_convocatoria = 0;
        foreach ($aux_post as $key => $value)
        {
            if (strpos($key, 'convocatoria') > -1)
            {
                $part = explode('_', $key);
                $convocatoria[] = $part[1];
                unset($aux_post[$key]);
                $is_convocatoria = 1;
            }
        }
        $post = $aux_post;
        if ($is_convocatoria == 1)
        {
            $post['categoria_convocada'] = 1;
        } else
        {
            $post['categoria_convocada'] = "";
        }
//        pr($post);
        /**
         * Comienzan las validaciones
         */
        $rules = $this->get_validaciones(Implementaciones::ET_DATOS_GENERALES);
        $id_implementacion = $post['implementacion'];
//        pr($rules);
//        pr($post);
        $this->load->library('form_validation');
        $this->form_validation->set_data($post);
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run())
        {
            $resultado = 0;
            $datos = [
                'clave_curso' => $post['curso'],
                'clave_implementacion' => $post['clave_implementacion'],
                'clave_unidad_sede' => $post['sede'],
                'id_regla_tipo_curso' => $post['reglas_tipo_curso'],
                'objetivo' => ($post['objetivo_implementacion']) ? $post['objetivo_implementacion'] : null,
                'contenido' => ($post['contenido_implementacion']) ? $post['contenido_implementacion'] : null,
            ];
            if (!empty($id_implementacion))
            {//Actualiza
//            pr('$genia---------------');
                $resultado = $this->imp->update_implementacion_step1($id_implementacion, $datos, $convocatoria);
            } else
            {//inserta
                $resultado = $this->imp->insert_implementacion_step1($datos, $convocatoria);
            }
        }
        $data = [];
        $value = $this->etapas[Implementaciones::ET_DATOS_GENERALES];
        $key_etapa = Implementaciones::ET_DATOS_GENERALES;
        $catalogos = $this->get_catalogos($value['catalogos']); //Obtiene los catálogos de la vista
        $datos_implementacion = [];
        if (!empty($id_implementacion))
        {
            $datos_implementacion = $this->get_detalle_implementacion(array('i.id_implementacion' => $id_implementacion));
            $datos_implementacion['categorias'] = $this->imp->get_categorias_implementacion(array('i.id_implementacion' => $id_implementacion), ['ci.id_categoria']);
        }
        $post['clave_convocatoria'] = $convocatoria;
        $data['html'] = $this->load->view($value['vista'], ['etapa' => $key_etapa, 'catalogos' => $catalogos, 'data' => $datos_implementacion, 'post' => $post], true); //
        if (isset($resultado))
        {//Control de guardado
            if ($resultado > 0)
            {
                $data['tp_msg'] = En_tpmsg::SUCCESS;
                $data['msg'] = $msj['success'];
            } else
            {
                $data['tp_msg'] = En_tpmsg::DANGER;
                $data['msg'] = $msj['danger'];
            }
            echo $json = json_encode($data);
        } else
        {
            echo $data['html'];
        }
//        return json_encode($value);
    }

    private function get_validaciones($tipo_etapa)
    {
        $this->load->config('form_validation');
        $rules = $this->config->item('etapa_' . $tipo_etapa);
        return $rules;
    }

    /**
     * 
     * @author LEAS
     * @fecha 26/02/2018
     * @param type $post
     */
    private function insertupdate_profesores($post)
    {
        
    }

    /**
     * 
     * @author LEAS
     * @fecha 26/02/2018
     * @param type $post
     */
    private function insertupdate_programacion($post)
    {
        
    }

    /**
     * 
     * @author LEAS
     * @fecha 26/02/2018
     * @param type $post
     */
    private function insertupdate_alumnos($post)
    {
        
    }

    /**
     * @author LEAS
     * @fecha 23/02/2018
     * @description Cambia el estado del curso
     */
    public function cambiar_estado()
    {
        $return = [];
        $msj = ['info' => 'No fue posible el cambio de estado.',
            'error' => 'Ocurrio un error durante el proceso. Por favor intentelo más tarde',
            'succes' => 'EL cambio se ejecuto correcatamente',
            'observaciones' => 'Se requieren observaciones'
        ];
        if ($this->input->is_ajax_request())
        {
            $post = $this->input->post(null, true);
            if ($post)
            {
                $id_implementacion = $post['implementacion'];
                $detalle_imp = $this->imp->get_implementacion(array("i.id_implementacion" => $id_implementacion)); //Obtiene implementacion
//                pr($detalle_imp);
                if (!empty($detalle_imp))
                {//Existe la implementación por tanto se validará la actualizacion
                    $this->load->model('Catalogo_model', 'cat');
                    $estados_implementacion = $this->cat->get_estados_implementacion();
//                pr($detalle_imp);
//                pr($estados_implementacion);
                    $estado_actual = $estados_implementacion[$detalle_imp[0]['cve_estado_implementacion']];
                    $tipo = $post['tipo'];
//                    pr($estado_actual);
                    if (in_array($tipo, $estado_actual['transicion']))
                    {//Valida que el estado de transición si exista
                        $estado_transicion = $estados_implementacion[$tipo];
                        switch ($estado_transicion['requiere_observaciones'])
                        {
                            case '1':
                                if (isset($post['observaciones']) && !empty($post['observaciones']))
//                                    $return['pruebas'] = $post['observaciones_cancelado'];
                                {//todo es correcto
                                    $datos = ['id_implementacion' => $id_implementacion, 'cve_estado_implementacion' => $tipo, 'observaciones' => $post['observaciones']];
                                    $update = $this->imp->update_status_implementacion($datos);
                                    if ($update > 0)
                                    {//Actualizacion correctamente
                                        $return['tp_msg'] = En_tpmsg::SUCCESS;
                                        $return['msg'] = $msj['succes'];
                                    } else
                                    {//No fue posible la actualización
                                        $return['tp_msg'] = En_tpmsg::DANGER;
                                        $return['msg'] = $msj['error'];
                                    }
                                } else
                                {
                                    $return['tp_msg'] = En_tpmsg::DANGER;
                                    $return['msg'] = $msj['observaciones'];
                                }
                                break;
                            default :

                                $datos = ['id_implementacion' => $id_implementacion, 'cve_estado_implementacion' => $tipo];
//                                pr($datos);
                                $update = $this->imp->update_status_implementacion($datos);
                                if ($update > 0)
                                {//Actualizacion correctamente
                                    $return['tp_msg'] = En_tpmsg::SUCCESS;
                                    $return['msg'] = $msj['succes'];
                                } else
                                {//No fue posible la actualización
                                    $return['tp_msg'] = En_tpmsg::DANGER;
                                    $return['msg'] = $msj['error'];
                                }
                        }
                    } else
                    {

                        $return['tp_msg'] = En_tpmsg::INFO;
                        $return['msg'] = $msj['info'];
                    }
                } else
                {

                    $return['tp_msg'] = En_tpmsg::INFO;
                    $return['msg'] = $msj['info'];
                }
            } else
            {
                $return['tp_msg'] = En_tpmsg::INFO;
                $return['msg'] = $msj['info'];
            }
        } else
        {
            $return['tp_msg'] = En_tpmsg::INFO;
            $return['msg'] = $msj['info'];
        }
        echo json_encode($return);
    }

    public function get_carga_implementacion($cve_implementacion = null)
    {
        $data = array();
        $datos_wizard["cve_implementacion"] = "";
        $datos_wizard['catalogos'] = [];
        $data = [];
        if (!is_null($cve_implementacion))
        {
            $data = $this->get_detalle_implementacion(array('i.id_implementacion' => $cve_implementacion));

            $data['categorias'] = $this->imp->get_categorias_implementacion(array('i.id_implementacion' => $cve_implementacion), ['ci.id_categoria']);
//            pr($datos_wizard);
        }
//        pr($data);
        foreach ($this->etapas as $key_etapa => $value)
        {
            $catalogos = $this->get_catalogos($value['catalogos']); //Obtiene los catálogos de la vista
            $datos_wizard['catalogos'] = array_merge($datos_wizard['catalogos'], $catalogos);
            $datos_wizard['step' . $key_etapa] = $this->load->view($value['vista'], ['etapa' => $key_etapa, 'catalogos' => $catalogos, 'data' => $data], true); //
        }
        $this->load->view('/implementaciones/wizard_etapas.php', $datos_wizard, FALSE);
    }

    private function get_detalle_implementacion($filtros = null)
    {
        $result = $this->imp->get_implementacion($filtros);
        if (!empty($result))
        {
            return $result[0];
        }
        return [];
    }

    protected function get_listado_implementaciones($filtro)
    {
        
    }

    public function exportar_detalle($id)
    {
        LNiveles_acceso::Super;
    }

    public function exportar_listado()
    {
        LNiveles_acceso::Super;
    }

}
