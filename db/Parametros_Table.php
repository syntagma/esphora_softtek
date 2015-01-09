<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Parametros_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'));
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'parametro' => array(
            'type'    => 'varchar',
            'size'    => 50,
            'require' => true,
            'default' => ''
        ),

        'valor'     => array(
            'type' => 'varchar',
            'size' => 250
        )

    );

    /*
     * Index definitions
     */
    var $idx = array(

        'PRIMARY' => array(
            'type' => 'primary',
            'cols' => 'parametro'
        )

    );

}

?>