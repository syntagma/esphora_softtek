<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Moneda_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'),
					'listView' => array(	
								'select' 	=> 'MONEDA.id_moneda, MONEDA.codigo, MONEDA.descripcion, MONEDA.codigo_moneda_afip, MONEDA.fecha_creacion, UC.login "usr_creacion", MONEDA.fecha_ult_modificacion, UM.login "usr_ult_modificacion", MONEDA.activo',
								'from'		=> 'MONEDA , USUARIO UC, USUARIO UM',
								'where'		=> 'MONEDA.usr_creacion = UC.id_usuario and MONEDA.usr_ult_modificacion = UM.id_usuario'
					)
			);
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_moneda'        => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'codigo'            => array(
            'type'    => 'varchar',
            'size'    => 3,
            'require' => true,
            'default' => ''
        ),
        'descripcion'            => array(
            'type'    => 'varchar',
            'size'    => 45,
            'require' => true,
            'default' => ''
        ),

        'codigo_moneda_afip'             => array(
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
            'cols' => 'id_moneda'
        )

    );

}

?>