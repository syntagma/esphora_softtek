<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Licencia_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'));
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

        'id_modulo'              => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'fecha_desde_validez'    => array(
            'type' => 'date'
        ),

        'fecha_hasta_validez'    => array(
            'type' => 'date'
        ),

        'fecha_creacion'         => array(
            'type'    => 'timestamp',
            'require' => true,
            'default' => ''
        ),

        'usr_creacion'           => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'fecha_ult_modificacion' => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'usr_ult_modificacion'   => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'activo'                 => array(
            'type' => 'char',
            'size' => 1
        )

    );

    /*
     * Index definitions
     */
    var $idx = array(

        'id_modulo' => array(
            'type' => 'normal',
            'cols' => 'id_modulo'
        ),

        'PRIMARY'   => array(
            'type' => 'primary',
            'cols' => array(
                'id_empresa',
                'id_modulo'
            )
        )

    );

}

?>