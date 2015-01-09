<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Tipo_comprobante_Table extends DB_Table {
public $sql = array (
		'all' => array ('select' => '*'),
		'listView' => array(	'select' 	=> 'T.id_tipo_comprobante, T.descripcion, T.cod_comprobante, T.nombre_corto, T.letra, T.fecha_creacion, UC.login "usr_creacion", T.fecha_ult_modificacion, UM.login "usr_ult_modificacion", T.activo',
								'from'		=> 'TIPO_COMPROBANTE T, USUARIO UC, USUARIO UM',
								'where'		=> 'T.usr_creacion = UC.id_usuario and T.usr_ult_modificacion = UM.id_usuario'
							),
	);
	
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_tipo_comprobante'    => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'descripcion'            => array(
            'type'    => 'varchar',
            'size'    => 50,
            'require' => true,
            'default' => ''
        ),

        'cod_comprobante'        => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),
        
        'nombre_corto'            => array(
            'type'    => 'varchar',
            'size'    => 45,
            'require' => true,
            'default' => ''
        ),
        
        'letra'            => array(
            'type'    => 'char',
            'size'    => 1,
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
            'cols' => 'id_tipo_comprobante'
        )

    );

}

?>