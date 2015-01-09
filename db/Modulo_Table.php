<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Modulo_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'));
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_modulo'              => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'nombre'                 => array(
            'type'    => 'char',
            'size'    => 20,
            'require' => true,
            'default' => ''
        ),

        'nombre_corto'           => array(
            'type'    => 'char',
            'size'    => 2,
            'require' => true,
            'default' => ''
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

        'PRIMARY' => array(
            'type' => 'primary',
            'cols' => 'id_modulo'
        )

    );

}

?>