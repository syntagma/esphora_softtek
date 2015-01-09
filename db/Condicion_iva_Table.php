<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Condicion_iva_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'),
					'listView' => array(	
								'select' 	=> 'CONDICION_IVA.id_condicion_iva, CONDICION_IVA.descripcion, CONDICION_IVA.codigo_afip, CONDICION_IVA.fecha_creacion, UC.login "usr_creacion", CONDICION_IVA.fecha_ult_modificacion, UM.login "usr_ult_modificacion", CONDICION_IVA.activo',
								'from'		=> 'CONDICION_IVA , USUARIO UC, USUARIO UM',
								'where'		=> 'CONDICION_IVA.usr_creacion = UC.id_usuario and CONDICION_IVA.usr_ult_modificacion = UM.id_usuario'
					)
	);
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_condicion_iva'       => array(
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

        'codigo_afip' => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
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
            'cols' => 'id_condicion_iva'
        )

    );

}

?>