<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Empresa_Table extends DB_Table {
public $sql = array (
		'all' => array ('select' => '*'),
		'listView' => array(	'select' 	=> 'E.id_empresa, E.nombre, TD.descripcion "tipo_documento", E.nro_documento, E.calle, E.numero, E.piso, E.departamento, E.codigo_postal, E.ciudad, PR.descripcion "provincia", PA.descripcion "pais", E.telefono, E.fecha_inicio_actividades, E.ingresos_brutos, E.nombre_fantasia, E.fecha_creacion, UC.login "usr_creacion", E.fecha_ult_modificacion, UM.login "usr_ult_modificacion", E.activo',
								'from'		=> 'EMPRESA E, TIPO_DOCUMENTO TD, PROVINCIA PR, PAIS PA, USUARIO UC, USUARIO UM',
								'where'		=> 'E.id_tipo_documento = TD.id_tipo_documento and E.id_pais = PA.id_pais and E.id_provincia = PR.id_provincia and E.usr_creacion = UC.id_usuario and E.usr_ult_modificacion = UM.id_usuario'
							),
	);


public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_empresa'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'id_tipo_documento'      => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),
		
		'id_moneda'      => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'nro_documento'          => array(
            'type'    => 'decimal',
            'size'    => 50,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'nombre'                 => array(
            'type'    => 'varchar',
            'size'    => 50,
            'require' => true,
            'default' => ''
        ),

        'calle'                  => array(
            'type' => 'varchar',
            'size' => 50
        ),

        'numero'                 => array(
            'type' => 'bigint'
        ),

        'piso'                   => array(
            'type' => 'bigint'
        ),

        'departamento'           => array(
            'type' => 'varchar',
            'size' => 50
        ),

        'codigo_postal'          => array(
            'type' => 'bigint'
        ),

        'ciudad'                 => array(
            'type' => 'varchar',
            'size' => 50
        ),

        'id_provincia'           => array(
            'type' => 'bigint'
        ),

        'id_pais'                => array(
            'type' => 'bigint'
        ),

        'telefono'               => array(
            'type' => 'varchar',
            'size' => 20
        ),
        
        'fecha_inicio_actividades'         => array(
            'type'    => 'timestamp',
            'require' => true,
            'default' => ''
        ),
        
        'ingresos_brutos'           => array(
            'type' => 'char',
            'size' => 11
        ),
        
        'nombre_fantasia'                 => array(
            'type'    => 'varchar',
            'size'    => 250,
            'require' => true,
            'default' => ''
        ),

        'fecha_creacion'         => array(
            'type'    => 'timestamp',
            'require' => true,
            'default' => ''
        ),

        'usr_creacion'           => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'fecha_ult_modificacion' => array(
            'type'    => 'timestamp',
            'require' => true,
            'default' => ''
        ),

        'usr_ult_modificacion'   => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'activo'                 => array(
            'type'    => 'char',
            'size'    => 1,
            'require' => true,
            'default' => ''
        )

    );

    /*
     * Index definitions
     */
    var $idx = array(

        'id_pais'           => array(
            'type' => 'normal',
            'cols' => 'id_pais'
        ),

        'id_provincia'      => array(
            'type' => 'normal',
            'cols' => 'id_provincia'
        ),

        'id_tipo_documento' => array(
            'type' => 'normal',
            'cols' => 'id_tipo_documento'
        ),

        'PRIMARY'           => array(
            'type' => 'primary',
            'cols' => 'id_empresa'
        )

    );

}

?>