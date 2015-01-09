<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Detalle_percepciones_compra_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'));
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_detalle_percepciones_compra'   => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'id_compra'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'id_retencion'           => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'detalle'                => array(
            'type'    => 'varchar',
            'size'    => 45,
        ),
		
		'id_provincia'           => array(
            'type'    => 'bigint',
        ),

        'base_imponible'         => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'alicuota'               => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
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

        'id_compra'   => array(
            'type' => 'normal',
            'cols' => 'id_factura'
        ),

        'id_retencion' => array(
            'type' => 'normal',
            'cols' => 'id_retencion'
        ),

        'PRIMARY'      => array(
            'type' => 'primary',
            'cols' => 'id_detalle_percepciones_compra'
        )

    );

}

?>
