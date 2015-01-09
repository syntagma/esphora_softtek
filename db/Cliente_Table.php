<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Cliente_Table extends DB_Table {
public $sql = array (
	'all' 				=> array (	'select'=> '*'),

	'selectListView' 	=> array (	'select'=> 'c.id_cliente, c.razon_social "descripcion_cliente", td.descripcion "tipo_documento", c.nro_documento',
									'from'	=> 'CLIENTE c, TIPO_DOCUMENTO td',
									'where' => "c.id_tipo_documento = td.id_tipo_documento and c.activo = 'S'"
	),
	
	'listView'			=> array (	'select'=> 'C.id_cliente, C.razon_social, TD.descripcion tipo_documento, C.nro_documento, C.email, C.calle, C.numero, C.piso, C.departamento, C.codigo_postal, C.ciudad, PR.descripcion provincia, PA.descripcion pais, C.telefono, C.fecha_creacion, U1.login usr_creacion, C.fecha_ult_modificacion, U2.login  usr_ult_modificacion, C.activo',
									'from'	=> 'CLIENTE C, TIPO_DOCUMENTO TD, PROVINCIA PR, PAIS PA, USUARIO U1, USUARIO U2',
									'where' => 'C.id_tipo_documento = TD.id_tipo_documento and C.id_provincia = PR.id_provincia and C.id_pais = PA.id_pais and C.usr_creacion = U1.id_usuario and C.usr_ult_modificacion = U2.id_usuario'
	)
);


public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_cliente'                 => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'razon_social'               => array(
            'type'    => 'char',
            'size'    => 60,
            'require' => true,
            'default' => ''
        ),

        'id_tipo_documento'          => array(
            'type' => 'bigint'
        ),
        
        'id_condicion_iva'          => array(
            'type' => 'bigint'
        ),

        'nro_documento'              => array(
            'type'  => 'decimal',
            'size'  => 20,
            'scope' => 2
        ),

        'email'                      => array(
            'type' => 'char',
            'size' => 60
        ),

        'calle'                      => array(
            'type' => 'char',
            'size' => 30
        ),

        'numero'                     => array(
            'type'  => 'decimal',
            'size'  => 5
        ),

        'piso'                       => array(
            'type'  => 'decimal',
            'size'  => 2
        ),

        'departamento'               => array(
            'type' => 'char',
            'size' => 5
        ),

        'codigo_postal'              => array(
            'type' => 'char',
            'size' => 8
        ),

        'ciudad'                     => array(
            'type' => 'char',
            'size' => 30
        ),

        'id_provincia'               => array(
            'type' => 'bigint',
        	'default' => 0
        ),

        'id_pais'                    => array(
            'type' => 'bigint',
        	'default' => 0
        ),

        'imprimir_factura'           => array(
            'type'    => 'char',
            'size'    => 1,
            'default' => 'S'
        ),

        'enviar_factura_electronica' => array(
            'type'    => 'char',
            'size'    => 1,
            'default' => 'S'
        ),

        'telefono'                   => array(
            'type' => 'varchar',
            'size' => 20
        ),

        'fecha_creacion'             => array(
            'type'    => 'timestamp',
            'require' => true,
            'default' => ''
        ),

        'usr_creacion'               => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'fecha_ult_modificacion'     => array(
            'type'    => 'timestamp',
            'require' => true,
            'default' => ''
        ),

        'usr_ult_modificacion'       => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'activo'                     => array(
            'type' => 'char',
            'size' => 1
        )

    );

    /*
     * Index definitions
     */
    var $idx = array(

        'id_pais'           => array(
            'type' => 'normal',
            'cols' => 'id_pais'
        ),

        'id_provincia'      => array(
            'type' => 'normal',
            'cols' => 'id_provincia'
        ),

        'id_tipo_documento' => array(
            'type' => 'normal',
            'cols' => 'id_tipo_documento'
        ),

        'PRIMARY'           => array(
            'type' => 'primary',
            'cols' => 'id_cliente'
        )

    );

}

?>