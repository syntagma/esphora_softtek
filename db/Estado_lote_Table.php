<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Estado_lote_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'));
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_estado_lote'         => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'descripcion'            => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'fecha_creacion'         => array(
            'type'    => 'timestamp',
            'require' => true,
            'default' => ''
        ),

        'usr_crecion'            => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'fecha_ult_modificacion' => array(
            'type'    => 'timestamp',
            'require' => true,
            'default' => ''
        ),

        'usr_utl_modificacion'   => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
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
            'cols' => 'id_estado_lote'
        )

    );

}

?>