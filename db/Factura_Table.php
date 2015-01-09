<?php
/*
 * Include basic class
 */
require_once ("DB/Table.php");

/*
 * Create the table object
 */
class Factura_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'),
					 'maxNro' => array('select' => 'max(nro_factura) "numero_factura"'),

					'listaFacturas' => array (
		'select' => 'FACTURA.id_factura, PUNTO_VENTA.numero, FACTURA.nro_factura, TIPO_COMPROBANTE.descripcion "tipo_comprobante", CLIENTE.razon_social "cliente", FACTURA.total, FACTURA.importe_neto_gravado, FACTURA.impuesto_liquidado, FACTURA.importe_ope_exentas',
		'from' => 'FACTURA, CLIENTE, TIPO_COMPROBANTE, PUNTO_VENTA',
		'where' => 'FACTURA.id_cliente = CLIENTE.id_cliente and FACTURA.id_tipo_comprobante = TIPO_COMPROBANTE.id_tipo_comprobante and FACTURA.id_punto_venta = PUNTO_VENTA.id_punto_venta'
	),
					'facturasByLote' => array (
		'select' => "TD.cod_doc_afip 'tipo_doc', C.nro_documento 'nro_doc', TC.cod_comprobante 'tipo_cbte', right(concat('0000', PUNTO_VENTA.numero), 4) 'punto_vta', F.nro_factura 'cbt_desde', F.nro_factura 'cbt_hasta' , F.total 'imp_total',  F.total 'imp_tot_conc', F.importe_neto_gravado 'imp_neto', F.impuesto_liquidado 'impto_liq', F.impuesto_liquidado_rni 'impto_liq_rni', F.importe_ope_exentas 'imp_op_ex', F.fec_cbte 'fecha_cbte', F.fec_serv_desde 'fecha_serv_desde', F.fec_serv_hasta 'fecha_serv_hasta', F.fecha_venc_pago",
		'from' => 'FACTURA F, CLIENTE C, TIPO_DOCUMENTO TD, FACTURA_LOTE FL, TIPO_COMPROBANTE TC, PUNTO_VENTA',
		'where' => 'F.id_cliente = C.id_cliente and C.id_tipo_documento = TD.id_tipo_documento and F.id_factura = FL.id_factura and F.id_tipo_comprobante = TC.id_tipo_comprobante and F.id_punto_venta = PUNTO_VENTA.id_punto_venta'
	),
					'listView' => array (
		'select' => "FACTURA.id_factura, FACTURA.detallada, TIPO_COMPROBANTE.descripcion 'tipo_comprobante', right(concat('0000', PUNTO_VENTA.numero), 4) 'pto_vta', right(concat('00000000', FACTURA.nro_factura), 8) 'nro_factura', TIPO_DOCUMENTO.descripcion 'tipo_documento', CLIENTE.nro_documento 'nro_documento', CLIENTE.razon_social 'razon_social', FACTURA.total, FACTURA.fec_cbte, FACTURA.cae 'cae', FACTURA.id_afip 'id_afip'",
		'from' => 'FACTURA, CLIENTE, TIPO_DOCUMENTO, PUNTO_VENTA, TIPO_COMPROBANTE',
		'where' => 'FACTURA.id_cliente = CLIENTE.id_cliente and CLIENTE.id_tipo_documento = TIPO_DOCUMENTO.id_tipo_documento and FACTURA.id_punto_venta = PUNTO_VENTA.id_punto_venta and FACTURA.id_tipo_comprobante = TIPO_COMPROBANTE.id_tipo_comprobante'
	),
	
					'listaFacturasByLote' => array (
		'select' => "F.id_factura, concat(right(concat('0000', PUNTO_VENTA.numero), 4), '-', right(concat('00000000', F.nro_factura), 8)) 'Numero', F.fec_cbte, F.total, F.cae",
		'from' => 'FACTURA F, FACTURA_LOTE FL, PUNTO_VENTA',
		'where' => 'F.id_factura = FL.id_factura and F.id_punto_venta = PUNTO_VENTA.id_punto_venta'
	),
	
					'motivosRechazo' => array (
		'select' => "MR.descripcion",
		'from' => 'FACTURA_MOTIVO_RECHAZO FMR, MOTIVO_RECHAZO MR',
		'where' => 'FMR.id_motivo_rechazo = MR.id_motivo_rechazo'
	),
);
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_factura'             => array(
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

        'id_punto_venta'                => array(
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
        
        'otros_conceptos'    => array(
            'type'    => 'decimal',
            'size'    => 10,
            'scope'   => 2,
            'require' => true,
            'default' => ''
        ),

        'fec_serv_desde'         => array(
            'type'    => 'date',
            'require' => false,
            'default' => ''
        ),

        'fec_serv_hasta'         => array(
            'type'    => 'date',
            'require' => false,
            'default' => ''
        ),

        'fecha_venc_pago'        => array(
            'type'    => 'date',
            'require' => true,
            'default' => ''
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

        'presta_serv'            => array(
            'type'    => 'char',
            'size'    => 1,
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

		'id_afip' => array(
            'type'    => 'decimal',
            'size'    => 15,
            'require' => false,
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

        'id_cliente'             => array(
            'type' => 'bigint'
        )

    );

    /*
     * Index definitions
     */
    var $idx = array(

        'id_cliente'            => array(
            'type' => 'normal',
            'cols' => 'id_cliente'
        ),

        'id_empresa'            => array(
            'type' => 'normal',
            'cols' => 'id_empresa'
        ),

        'id_tipo_documento_cli' => array(
            'type' => 'normal',
            'cols' => 'id_tipo_documento_cli'
        ),

        'PRIMARY'               => array(
            'type' => 'primary',
            'cols' => 'id_factura'
        )

    );

}

?>