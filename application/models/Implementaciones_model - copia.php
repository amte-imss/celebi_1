<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Implementaciones_model extends MY_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get_listado_implementacion($filtros = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $select = [
            "i.clave_curso", "i.clave_implementacion", "c.nombre nombre_curso"
            , "i.activo", "e.cve_estado_implementacion", "e.nombre estado_implementacion"
            , "e.configurations->>'transicion'", "i.anio"
            , "e.configurations->>'requiere_observaciones' requiere_observaciones"
        ];
        $this->db->select($select); //Únicamente el último estado
        $this->db->join('presenciales.curso c', 'c.clave_curso = i.clave_curso', 'inner');
        $this->db->join('presenciales.historico_estado_implementacion hi', 'i.id_implementacion = hi.id_implementacion', 'inner');
        $this->db->join('presenciales.estado_implementacion e', 'e.cve_estado_implementacion = hi.cve_estado_implementacion', 'inner');

        $this->db->where('hi.actual', true); //Únicamente el último estado
        if (!is_null($filtros))
        {
            $this->db->where($filtros);
        }

        $res = $this->db->get('presenciales.implementacion i')->result_array();
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res;
    }

    public function get_implementacion($filtros)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $select = [
            "i.clave_curso", "i.clave_implementacion", "i.id_implementacion",
            "i.contenido contenido_implementacion", "i.objetivo", "i.anio",
            "i.clave_unidad_sede", "i.asistencias_minimas_aprobatorias"
            , "i.horas_aula", "i.horas_extra"
            , "c.nombre nombre_curso", "c.id_tipo_curso",
            "i.id_regla_tipo_curso", "i.clave_unidad_sede"
        ];
        $this->db->select($select); //Únicamente el último estado
        $this->db->join('presenciales.implementacion i', 'i.id_implementacion = hi.id_implementacion', 'inner');
        $this->db->join('presenciales.estado_implementacion e ', 'e.cve_estado_implementacion = hi.cve_estado_implementacion', 'inner');
        $this->db->join('presenciales.curso c', 'c.clave_curso = i.clave_curso', 'inner');
        $this->db->where("hi.actual", true);

        if (!is_null($filtros))
        {
            $this->db->where($filtros);
        }

        $res = $this->db->get('presenciales.historico_estado_implementacion hi')->result_array();
//        pr($this->db->last_query());
        return $res;
    }

    public function get_categorias_implementacion($filtros, $select = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        if (is_null($select))
        {
            $select = [
                "ci.id_categoria", "cc.nombre", "cc.id_categoria_padre"
            ];
        }
        $this->db->select($select); //Únicamente el último estado
        $this->db->join('presenciales.implementacion i', 'i.id_implementacion = ci.id_implementacion', 'inner');
        $this->db->join('presenciales.categoria_convocada cc', 'cc.id_categoria = ci.id_categoria', 'inner');

        if (!is_null($filtros))
        {
            $this->db->where($filtros);
        }

        $res = $this->db->get('presenciales.categoria_implementacion ci')->result_array();
//        pr($this->db->last_query());
        return $res;
    }

    public function get_historico_implementacion($filtro)
    {
        $this->db->where($filtros);
        $res = $this->db->get('presenciales.historico_estado_implementacion h')->result_array();
        return $res;
    }

    public function update_implementacion_step1($implementacion, $datos, $convocatoria)
    {
        $result = 0;
        $this->db->trans_begin();

        $this->db->where('id_implementacion', $implementacion);
        $this->db->delete('presenciales.categoria_implementacion');
        $guardado_convocatoria = 1;
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        } else
        {
            foreach ($convocatoria as $value)
            {
                $this->db->insert('presenciales.categoria_implementacion', array('id_implementacion' => $implementacion, 'id_categoria' => $value));
//                $id = $this->db->insert_id();
                if ($this->db->trans_status() === FALSE)
                {
                    $guardado_convocatoria = 0;
                    break;
                }
            }

            if ($guardado_convocatoria == 0)
            {
                $this->db->trans_rollback();
            } else
            {
                $this->db->where('id_implementacion', $implementacion);
                $this->db->update('presenciales.implementacion', $datos);
                if ($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                } else
                {
                    $this->db->trans_commit();
                    $result = 1;
                }
            }
        }
        return $result;
    }

    public function update_status_implementacion($datos)
    {
        $result = 0;
        $this->db->trans_begin();
        $this->db->where('clave_implementacion', $datos['clave_implementacion']);
        $this->db->update('presenciales.historico_estado_implementacion', array('actual' => FALSE));
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        } else
        {

            $this->db->insert('presenciales.historico_estado_implementacion', $datos);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
            } else
            {
                $result = $this->db->insert_id();
                $this->db->trans_commit();
            }
        }

        return $result;
    }

    public function insert_implementacion($datos)
    {
        
    }

}
