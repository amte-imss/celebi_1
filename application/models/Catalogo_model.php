<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogo_model extends MY_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
    * @author CPMS
    * @date 26/02/2018
    * @param arreglo con los filtros que se aplicaran a la busqueda
    * @return array
    */
    public function get_reglas_tipo_curso($filtros=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();


        $select = array("r.*","tc.nombre");
        $this->db->select($select);
        $this->db->join('presenciales.tipo_curso tc', 'r.id_tipo_curso = tc.id_tipo_curso', 'inner');
        
        if (!is_null($filtros))
        {
            $this->db->where($filtros);
        }

        $res = $this->db->get('presenciales.reglas_tipo_curso r');
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();

    }

    /**
     * @author LEAS
     * @Fecha 22/02/2018
     * @param type $filtros filtros del catalogo
     * @return type array con los diferentes estados por los que debera 
     * transitar una implementación
     * 
     */
    public function get_estados_implementacion($filtros = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        if (!is_null($filtros))
        {
            $this->db->where($filtros);
        }

        $this->db->where("e.activo", TRUE);

        $select = array("e.cve_estado_implementacion", "e.nombre", "e.configurations", "descripcion");
//
        $this->db->select($select);
        $res = $this->db->get('presenciales.estado_implementacion e')->result_array();

        if (!empty($res) and isset($res[0]['configurations']))
        {
            $complementa = [];
            foreach ($res as $value)
            {
                $configurations = (array) json_decode($value['configurations']);
                unset($value['configurations']);
                $value = array_merge($value, $configurations);
                $complementa[$value['cve_estado_implementacion']] = $value;
            }
            $res = $complementa;
        }
//        pr($res);
        return $res;
    }

    /**
     * 
     * @author LEAS
     * @fecha 18/05/2017
     * @return type catálogo de las delegaciones
     */
    public function get_delegaciones()
    {

        $select = array(
            'clave_delegacional', 'nombre',
        );
        $this->db->select($select);
        $this->db->where('activo', TRUE);

        $resultado = $this->db->get('catalogo.delegaciones');
//            pr($this->db->last_query());
        return $resultado->result_array();
    }

    /**
     * @author LEAS
     * @fecha 29/05/2017
     * @param type $clave_categoria Clave de la categoria del empleado o docente en el IMSS
     * @return array vacio en el caso de no encontrar datos decategoria del docente o del empleado,ç
     * si no, retorna informacion generales de la categoria
     */
    public function get_datos_categoria($clave_categoria)
    {
        $this->db->where('clave_categoria', $clave_categoria);
        $resultado = $this->db->get('catalogo.categorias');
        return $resultado->result_array();
    }

    /**
     * 
     * @author LEAS
     * @fecha 29/05/2017
     * @param type $clave_adscripcion Clave de adscripción del departamento donde se
     * labora el docente, 
     * @return array vacio, en el caso de que no encuentre datos de departamento, 
     * si no, retorna datos del departamento 
     * 
     */
    public function get_datos_departamento($clave_adscripcion)
    {
        $this->db->where('clave_departamental', $clave_adscripcion);
        $resultado = $this->db->get('catalogo.departamentos_instituto');
        return $resultado->result_array();
    }

    function get_registros($nombre_tabla = null, &$params = [])
    {
//        pr($params);
        if (is_null($nombre_tabla))
        {
            return [];
        }
        $this->db->flush_cache();
        $this->db->reset_query();
        if (isset($params['total']))
        {
            $select = 'count(*) total';
        } else if (isset($params['select']))
        {
            $select = $params['select'];
        } else
        {
            $select = '*';
        }
        $this->db->select($select);
        if (isset($params['join']))
        {
            foreach ($params['join'] as $value)
            {
                $this->db->join($value['table'], $value['condition'], $value['type']);
            }
        }
        if (isset($params['where']))
        {
            foreach ($params['where'] as $key => $value)
            {
                $this->db->where($key, $value);
            }
        }
        if (isset($params['like']))
        {
            foreach ($params['like'] as $key => $value)
            {
                $this->db->like($key, $value);
            }
        }
//        $this->db->where('date(fecha) = current_date', null, false);
        if (isset($params['limit']) && isset($params['offset']) && !isset($params['total']))
        {
            $this->db->limit($params['limit'], $params['offset']);
        } else if (isset($params['limit']) && !isset($params['total']))
        {
            $this->db->limit($params['limit']);
        }

        $query = $this->db->get($nombre_tabla);
        $salida = $query->result_array();
        $query->free_result();
        // pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();
        return $salida;
    }

}
