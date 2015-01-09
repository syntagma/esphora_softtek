<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Unidad_Medida_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'),
					'listView' => array(	
								'select' 	=> 'UNIDAD_MEDIDA.id_unidad_medida, UNIDAD_MEDIDA.descripcion, UNIDAD_MEDIDA.codigo_unidad_medida_afip, UNIDAD_MEDIDA.fecha_creacion, UC.login "usr_creacion", UNIDAD_MEDIDA.fecha_ult_modificacion, UM.login "usr_ult_modificacion", UNIDAD_MEDIDA.activo',
								'from'		=> 'UNIDAD_MEDIDA , USUARIO UC, USUARIO UM',
								'where'		=> 'UNIDAD_MEDIDA.usr_creacion = UC.id_usuario and UNIDAD_MEDIDA.usr_ult_modificacion = UM.id_usuario'
					)
	);
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_unidad_medida'        => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'descripcion'            => array(
            'type'    => 'varchar',
            'size'    => 45,
            'require' => true,
            'default' => ''
        ),

        'codigo_unidad_medida_afip'             => array(
            'type'    => 'varchar',
            'size'    => 3,
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

        'PRIMARY' => array(
            'type' => 'primary',
            'cols' => 'id_unidad_medida'
        )

    );

}

?>