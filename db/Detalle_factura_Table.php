<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Detalle_factura_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'));
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_detalle_factura'     => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'id_factura'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'concepto'               => array(
            'type'    => 'varchar',
            'size'    => 255,
            'require' => true,
            'default' => ''
        ),

        'cantidad'               => array(
            'type'    => 'double',
            'require' => true,
            'default' => 0
        ),

        'id_unidad_medida'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'precio_unitario'        => array(
            'type'    => 'double',
            'require' => true,
            'default' => 0
        ),

        'id_alicuota_iva'        => array(
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

        'id_factura'      => array(
            'type' => 'normal',
            'cols' => 'id_factura'
        ),

        'id_alicuota_iva' => array(
            'type' => 'normal',
            'cols' => 'id_alicuota_iva'
        ),

        'PRIMARY'         => array(
            'type' => 'primary',
            'cols' => 'id_detalle_factura'
        )

    );

}

?>