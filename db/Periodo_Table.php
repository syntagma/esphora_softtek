<?php
/*
 * Include basic class
 */
require_once 'DB/Table.php';

/*
 * Create the table object
 */
class Periodo_Table extends DB_Table {
public $sql = array ('all' => array ('select' => '*'),
					'listView' => array(	
								'select' 	=> 'PERIODO.id_periodo, PERIODO.nombre, PERIODO.fecha_inicio, PERIODO.fecha_fin, PERIODO.estado, PERIODO.fecha_creacion, UC.login "usr_creacion", PERIODO.fecha_ult_modificacion, UM.login "usr_ult_modificacion", PERIODO.activo',
								'from'		=> 'PERIODO , USUARIO UC, USUARIO UM',
								'where'		=> 'PERIODO.usr_creacion = UC.id_usuario and PERIODO.usr_ult_modificacion = UM.id_usuario'
					),
					'listCD' => array(	
								'select' 	=> 'PERIODO.id_periodo, PERIODO.nombre, PERIODO.fecha_inicio, PERIODO.fecha_fin',
								'from'		=> 'PERIODO',
								'where'		=> "PERIODO.estado = 'C' and PERIODO.activo = 'S'"
					)
	);
public $fetchmode = MDB2_FETCHMODE_ASSOC;

    /*
     * Column definitions
     */
    var $col = array(

        'id_periodo'       => array(
            'type'    => 'bigint',
            'require' => true,
            'default' => 0
        ),

        'nombre'            => array(
            'type'    => 'varchar',
            'size'    => 60,
            'require' => true,
            'default' => ''
        ),

        'fecha_inicio' => array(
            'type'    => 'date',
            'require' => true,
            'default' => 0
        ),
        
       'fecha_fin' => array(
            'type'    => 'date',
            'require' => true,
            'default' => 0
        ),
       'estado' => array(
            'type'    => 'char',
        	'size'    => 1,
            'require' => true,
            'default' => 0
        ),

        'id_empresa'       => array(
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
            'cols' => 'id_periodo'
        )

    );

}

?>