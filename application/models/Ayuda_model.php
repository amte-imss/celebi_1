<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ayuda_model extends MY_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author CPMS
     * @date 21/07/2017
     * @return array
     */
    public function get_ayudas_opcion($catalogo, $opciones, $column_ayuda = 'descripcion', $column_nombre = 'nombre')
    {
        $this->db->flush_cache();
        $this->db->reset_query();

//        $resutado = $this->db->get($catalogo);
//        return $resutado->result_array();
        $campo_llave = $this->get_campo_llave_primaria($catalogo);
        if (!is_null($campo_llave))
        {
            $campo_nombre = $this->get_columna_nombre($catalogo);
            if (is_null($campo_nombre))
            {
                $select = ["A." . $campo_llave . " id", "A." . $column_ayuda, "'' nombre"];
            } else
            {
                $select = ["A." . $campo_llave . " id", "A.descripcion", "A." . $campo_nombre . " " . $column_nombre];
            }
            $this->db->select($select);
            if (!empty($opciones))
            {
                $this->db->where_in("A." . $campo_llave, $opciones);
            }
            $this->db->order_by(1);
            $res = $this->db->get($catalogo . " A")->result_array();
            return $res;
        } else
        {
            return [];
        }
    }

    public function get_campo_llave_primaria($catalogo)
    {
        $select = ['a.attname campo_nombre', 'format_type(a.atttypid, a.atttypmod) AS tipo_dato'];
        $this->db->join('pg_attribute a', 'a.attrelid = i.indrelid AND a.attnum = ANY(i.indkey)');
        $this->db->select($select);
        $this->db->where('i.indrelid', "'" . $catalogo . "'::regclass", FALSE);
        $this->db->where("i.indisprimary", true);
        $res = $this->db->get('pg_index i')->result_array();
        $this->db->flush_cache();
        $this->db->reset_query();
        if (!empty($res))
        {
            return $res[0]['campo_nombre'];
        }
        return null;
    }

    public function get_columna_nombre($catalogo)
    {
        $select = ['t1.column_name AS columna_nombre'];
        $this->db->join('pg_class t2', '(t2.relname = t1.table_name)');
        $this->db->select($select);
        $this->db->where('concat("t1"."table_schema", \'.\', "t1"."table_name")=', $catalogo);
        $this->db->like("t1.column_name", 'nombre');
        $this->db->order_by("t1.table_name");
        $this->db->order_by("t1.ordinal_position");
        $res = $this->db->get('information_schema.columns t1')->result_array();
        $this->db->flush_cache();
        $this->db->reset_query();
        if (!empty($res))
        {
            return $res[0]['columna_nombre'];
        }
        return null;
    }

}
