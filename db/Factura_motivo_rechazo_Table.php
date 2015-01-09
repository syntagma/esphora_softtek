<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Factura_motivo_rechazo_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'));
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_motivo_rechazo' => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'id_factura'        => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        )

    );

    /*
     * Index definitions
     */
    var $idx = array(

        'PRIMARY' => array(
            'type' => 'primary',
            'cols' => array(
                'id_motivo_rechazo',
                'id_factura'
            )
        )

    );

}

?>