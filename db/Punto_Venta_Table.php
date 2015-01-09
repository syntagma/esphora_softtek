<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Punto_Venta_Table extends DB_Table {
public $sql = array (
		'all' => array ('select' => '*'),
		'listView' => array(	'select' 	=> 'P.id_punto_Venta, P.numero, case P.tipo_pto_vta when \'A\' then \'Aplicativo AFIP\' when \'E\' then \'Factura Electronica\' when \'M\' then \'Proceso Manual\' end "tipo_pto_vta", P.fecha_creacion, UC.login "usr_creacion", P.fecha_ult_modificacion, UM.login "usr_ult_modificacion", P.activo',
								'from'		=> 'PUNTO_VENTA P, USUARIO UC, USUARIO UM',
								'where'		=> 'P.usr_creacion = UC.id_usuario and P.usr_ult_modificacion = UM.id_usuario'
							),
	);
	
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_punto_venta'      => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'numero'            => array(
            'type'    => 'decimal',
            'size'    => 4,
        	'scope'   => 0,
            'require' => true,
        	'qf_rules' => array( 
                'required' => 'This field is required.'
        	)
        ),

        'tipo_pto_vta'           => array(
            'type'    => 'char',
            'size'    => 1,
            'require' => true,
            'default' => 'E',
        	'qf_rules' => array( 
                'required' => 'This field is required.',
			)
        ),
        
		'cai'           => array(
            'type'    => 'varchar',
            'size'    => 45,
        ),
        
		'fec_venc_cai'=> array(
            'type'    => 'date',
            'required'    => false,
        	'default'	=> ''
        ),
        
        'id_empresa'      => array(
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

        'PRIMARY' => array(
            'type' => 'primary',
            'cols' => 'id_punto_venta'
        )

    );

}

?>