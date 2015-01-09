<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Usuario_Table extends DB_Table {
	public $sql = array (
		'all' => array ('select' => '*'),
		'listView' => array(	'select' 	=> 'U.id_usuario, U.nombre, U.apellido, U.login, U.fecha_creacion, UC.login "usr_creacion", U.fecha_ult_modificacion, UM.login "usr_ult_modificacion", U.activo',
								'from'		=> 'USUARIO U, USUARIO UC, USUARIO UM',
								'where'		=> 'U.usr_creacion = UC.id_usuario and U.usr_ult_modificacion = UM.id_usuario'
							),
	);
	public $fetchmode = MDB2_FETCHMODE_ASSOC;

	
    /*
     * Column definitions
     */
	
    var $col = array(

        'id_usuario'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'nombre'                 => array(
            'type'    => 'varchar',
            'size'    => 50,
            'require' => true,
            'default' => ''
        ),

        'apellido'               => array(
            'type'    => 'varchar',
            'size'    => 50,
            'require' => true,
            'default' => ''
        ),

        'login'                  => array(
            'type'    => 'varchar',
            'size'    => 50,
            'require' => true,
            'default' => ''
        ),

        'password'               => array(
            'type'    => 'varchar',
            'size'    => 50,
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
            'cols' => 'id_usuario'
        )

    );

}

?>