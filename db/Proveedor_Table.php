<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Proveedor_Table extends DB_Table {
public $sql = array (
	'all' 				=> array (	'select'=> '*'),

	'selectListView' 	=> array (	'select'=> 'PROVEEDOR.id_proveedor, PROVEEDOR.razon_social "descripcion_proveedor", td.descripcion "tipo_documento", PROVEEDOR.nro_documento',
									'from'	=> 'PROVEEDOR , TIPO_DOCUMENTO td',
									'where' => "PROVEEDOR.id_tipo_documento = td.id_tipo_documento and PROVEEDOR.activo = 'S'"
	),
	
	'listView'			=> array (	'select'=> 'PROVEEDOR.id_proveedor, PROVEEDOR.razon_social, TIPO_DOCUMENTO.descripcion tipo_documento, PROVEEDOR.nro_documento, PROVEEDOR.email, PROVEEDOR.calle, PROVEEDOR.numero, PROVEEDOR.piso, PROVEEDOR.departamento, PROVEEDOR.codigo_postal, PROVEEDOR.ciudad, PR.descripcion provincia, PA.descripcion pais, PROVEEDOR.telefono, PROVEEDOR.fecha_creacion, U1.login usr_creacion, PROVEEDOR.fecha_ult_modificacion, U2.login  usr_ult_modificacion, PROVEEDOR.activo',
									'from'	=> 'PROVEEDOR , TIPO_DOCUMENTO, PROVINCIA PR, PAIS PA, USUARIO U1, USUARIO U2',
									'where' => 'PROVEEDOR.id_tipo_documento = TIPO_DOCUMENTO.id_tipo_documento and PROVEEDOR.id_provincia = PR.id_provincia and PROVEEDOR.id_pais = PA.id_pais and PROVEEDOR.usr_creacion = U1.id_usuario and PROVEEDOR.usr_ult_modificacion = U2.id_usuario'
	)
);


public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_proveedor'                 => array(
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