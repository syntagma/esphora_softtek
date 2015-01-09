<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Factura_lote_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'));
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_factura'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'id_lote'                => array(
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

        'id_factura' => array(
            'type' => 'normal',
            'cols' => 'id_factura'
        ),

        'id_lote'    => array(
            'type' => 'normal',
            'cols' => 'id_lote'
        ),

        'PRIMARY'    => array(
            'type' => 'primary',
            'cols' => array(
                'id_factura',
                'id_lote'
            )
        )

    );

}

?>