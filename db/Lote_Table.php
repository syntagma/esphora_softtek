<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Lote_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'),
			'listView' => array ('select' => 'l.id_lote "id_lote", l.mensaje_error, l.id_estado_lote, l.fecha "fecha_lote", right(concat(\'0000\', min(PUNTO_VENTA.numero)), 4) "pto_vta", right(concat(\'00000000\', min(f.nro_factura)), 8) "factura_desde", right(concat(\'00000000\', max(nro_factura)), 8) "factura_hasta", e.nro_documento "cuit_empresa", sum(f.total) "total"',
						 'from'	  => 'FACTURA_LOTE fl, LOTE l, FACTURA f, EMPRESA e, PUNTO_VENTA',
						 'where'  => "l.id_lote = fl.id_lote and f.id_factura = fl.id_factura and f.id_empresa = e.id_empresa and f.id_punto_venta = PUNTO_VENTA.id_punto_venta group by l.id_lote, l.fecha, e.nro_documento",
						 )
);
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_lote'                => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'fecha'                  => array(
            'type'    => 'timestamp',
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
        ),

        'id_estado_lote'         => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),
        
         'mensaje_error'         => array(
            'type'    => 'varchar',
            'size'    => 255,
			'require' => false
        )

    );

    /*
     * Index definitions
     */
    var $idx = array(

        'id_estado_lote' => array(
            'type' => 'normal',
            'cols' => 'id_estado_lote'
        ),

        'PRIMARY'        => array(
            'type' => 'primary',
            'cols' => 'id_lote'
        )

    );

}

?>