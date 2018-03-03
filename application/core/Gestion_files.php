<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author: LEAS
 * @version: 1.0
 * @desc: Interface para el manejo u administración de archivos 
 * (descarga, exportar y viasualización)
 * */
interface Gestion_files
{

    /**
     * 
     * @author LEAS
     * @fecha 15/02/2018
     * @param type $file 
     * @param type $file identificador o nombre del archivo solicitado. 
     * @description Visualiza el archivo de tipo pdf
     */
    public function get_ver_pdf($file = null);

    /**
     * @author LEAS
     * @fecha 15/02/2018
     * @param type $file identificador o nombre del archivo solicitado. 
     * @description Descarga el archivo solicitado
     */
    public function descarga_archivo($file = null);

    /**
     *
     * @param array $columnas Nombre de las columnas en el archivo
     * @param type $informacion Información o datos de la exportación
     * @param type $orden_columna Orden de las columnas
     * @param type $file_name Nombre del archivo exportado
     * @param type $delimiter delimitador del csv, por default será ","
     * @return type Descriptión documento a exportado ceon extención csv
     */
    public function exportar_xls($columnas = null, $informacion = null, $column_unset = null, $orden_columna = null, $file_name = 'tmp_file_export_data', $delimiter = ',');
}
