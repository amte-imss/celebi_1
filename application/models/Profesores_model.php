<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profesores_model extends MY_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get_profesor($filtros = null, $select = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();


        if (!is_null($filtros))
        {
            $this->db->where($filtros);
        }
        if (!is_null($select))
        {
            $this->db->select($select);
        }
        $this->db->where(array('is_profesor'=>true));
        $this->db->join('catalogo.delegaciones d', 'p.clave_delegacion = d.clave_delegacional', 'inner');
        $this->db->order_by('id_participante');

        $res = $this->db->get('presenciales.participantes p');
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function get_profesor_nomina($filtros=null, $select=null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();


        if (!is_null($filtros))
        {
            $this->db->where($filtros);
        }
        if (!is_null($select))
        {
            $this->db->select($select);
        }
        $this->db->join('catalogo.unidades_instituto u','n.clave_unidad =  u.clave_unidad and u.anio = n.anio', 'inner');
        $this->db->join('catalogo.delegaciones d','u.id_delegacion = d.id_delegacion', 'inner');

        $res = $this->db->get('nominas.nomina_historico n');
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function update_profesor($filtros, $datos)
    {
        
    }

    public function insert_profesor($datos)
    {
        $salida = false;
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->trans_begin();


        $this->db->insert('presenciales.participantes',$datos);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        } else
        {
            $this->db->trans_commit();
            $salida = true;
        }
        $this->db->flush_cache();
        $this->db->reset_query(); 
        return $salida;  
    }

    public function get_constancias($filtros)
    {
        
    }

    public function update_folio($filtros, $aprobado = true)
    {
        
    }

}
