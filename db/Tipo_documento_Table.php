<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Tipo_documento_Table extends DB_Table {
public $sql = array (
		'all' => array ('select' => '*'),
		'listView' => array(	'select' 	=> 'T.id_tipo_documento, T.descripcion, T.cod_doc_afip, T.fecha_creacion, UC.login "usr_creacion", T.fecha_ult_modificacion, UM.login "usr_ult_modificacion", T.activo',
								'from'		=> 'TIPO_DOCUMENTO T, USUARIO UC, USUARIO UM',
								'where'		=> 'T.usr_creacion = UC.id_usuario and T.usr_ult_modificacion = UM.id_usuario'
							),
	);
	
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_tipo_documento'      => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'descripcion'            => array(
            'type'    => 'varchar',
            'size'    => 50,
            'require' => true,
            'default' => '',
        	'qf_rules' => array( 
                'required' => 'This field is required.'
        	)
        ),

        'cod_doc_afip'           => array(
            'type'    => 'varchar',
            'size'    => 2,
            'require' => true,
            'default' => '',
        	'qf_rules' => array( 
                'required' => 'This field is required.',
        )
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
            'cols' => 'id_tipo_documento'
        )

    );

}

?>