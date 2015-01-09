<?php
/*
 * Include basic class
 */
require_once ("DB/Table.php");

/*
 * Create the table object
 */
class Compra_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'),
					'listaFacturas' => array (
		'select' => 'COMPRA.id_compra, COMPRA.punto_venta, COMPRA.nro_factura, TIPO_COMPROBANTE.descripcion "tipo_comprobante", PROVEEDOR.razon_social "Proveedor", COMPRA.total, COMPRA.importe_neto_gravado, COMPRA.impuesto_liquidado, COMPRA.importe_ope_exentas',
		'from' => 'COMPRA, PROVEEDOR, TIPO_COMPROBANTE',
		'where' => 'COMPRA.id_proveedor = PROVEEDOR.id_proveedor and COMPRA.id_tipo_comprobante = TIPO_COMPROBANTE.id_tipo_comprobante'
	),
					'listView' => array (
		'select' => "COMPRA.id_compra, COMPRA.detallada, TC.descripcion 'tipo_comprobante', right(concat('0000', COMPRA.punto_venta), 4) 'pto_vta', right(concat('00000000', COMPRA.nro_factura), 8) 'nro_factura', TD.descripcion 'tipo_documento', PROVEEDOR.nro_documento 'nro_documento', PROVEEDOR.razon_social 'razon_social', COMPRA.total, COMPRA.fec_cbte, COMPRA.cae 'cae'",
		'from' => 'COMPRA, PROVEEDOR, TIPO_DOCUMENTO TD, TIPO_COMPROBANTE TC',
		'where' => 'COMPRA.id_proveedor = PROVEEDOR.id_proveedor and PROVEEDOR.id_tipo_documento = TD.id_tipo_documento and COMPRA.id_tipo_comprobante = TC.id_tipo_comprobante'
	),
);
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(
        'id_compra'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'id_tipo_comprobante'    => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),
        
        'id_condicion_venta'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'punto_venta'                => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'nro_factura'            => array(
            'type'    => 'decimal',
            'size'    => 8,
            'scope'   => 0,
            'require' => true,
            'default' => ''
        ),

        'total'                  => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'importe_neto_gravado'   => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'impuesto_liquidado'     => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'impuesto_liquidado_rni' => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'importe_ope_exentas'    => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),
        
        'perc_iva'    => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),
        'perc_impuestos_nacionales'    => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),
        'perc_iibb'    => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),
        'perc_impuestos_municipales'    => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),
         'impuestos_internos'    => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'fecha_venc_pago'        => array(
            'type'    => 'date',
            'require' => false
        ),

        'fec_cbte'               => array(
            'type'    => 'date',
            'require' => true,
            'default' => ''
        ),

         'fec_registro_contable'               => array(
            'type'    => 'date',
            'require' => true,
            'default' => ''
        ),       
        'detallada'            => array(
            'type'    => 'char',
            'size'    => 1,
            'require' => true,
            'default' => 'N'
        ),
        
       'retenciones'            => array(
            'type'    => 'char',
            'size'    => 1,
            'require' => true,
            'default' => 'N'
        ),

        'id_empresa'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),
        
        'id_moneda'             => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),
        
        'cae'             => array(
            'type'    => 'varchar',
            'size' => 45,
            'default' => ' '
        ),
        
        'comentarios' => array(
            'type'    => 'varchar',
            'size'    => 255,
            'require' => false,
        ),
		
		'cotizacion'    => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 5,
            'require' => true,
            'default' => '1'
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
        ),

        'id_proveedor'             => array(
            'type' => 'bigint'
        )

    );

    /*
     * Index definitions
     */
    var $idx = array(

        'id_proveedor'            => array(
            'type' => 'normal',
            'cols' => 'id_proveedor'
        ),

        'id_empresa'            => array(
            'type' => 'normal',
            'cols' => 'id_empresa'
        ),

        'id_tipo_documento_prov' => array(
            'type' => 'normal',
            'cols' => 'id_tipo_documento_prov'
        ),

        'PRIMARY'               => array(
            'type' => 'primary',
            'cols' => 'id_compra'
        ),
        'SECONDARY'     => array(
            'type' => 'unique',
            'cols' => array(
                'id_proveedor',
                'punto_venta',
        		'nro_factura'
         )
        )
    );

}

?>