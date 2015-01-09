DROP TABLE IF EXISTS DETALLE_COMPRA;

CREATE TABLE  DETALLE_COMPRA (
  id_detalle_compra bigint(20) NOT NULL,
  id_compra bigint(20) unsigned NOT NULL,
  concepto varchar(250) NOT NULL,
  cantidad double NOT NULL,
  precio_unitario double NOT NULL,
  id_alicuota_iva bigint(20) unsigned NOT NULL,
  fecha_creacion datetime NOT NULL,
  usr_creacion decimal(10,0) NOT NULL,
  fecha_ult_modificacion datetime NOT NULL,
  usr_ult_modificacion decimal(10,0) NOT NULL,
  activo char(1) NOT NULL,
  id_unidad_medida bigint(20) NOT NULL,
  PRIMARY KEY  (id_detalle_compra),
  KEY id_compra (id_compra),
  KEY id_alicuota_iva (id_alicuota_iva),
  KEY FK_DETFAC_UNIMED (id_unidad_medida)
);

DROP TABLE IF EXISTS DETALLE_PERCEPCIONES_COMPRA;

CREATE TABLE  DETALLE_PERCEPCIONES_COMPRA (
  id_detalle_percepciones_compra bigint(20) NOT NULL,
  id_compra bigint(20) NOT NULL,
  id_retencion bigint(20) NOT NULL,
  detalle varchar(45) default NULL,
  id_provincia bigint(20) default NULL,
  base_imponible decimal(10,2) NOT NULL,
  alicuota decimal(10,2) NOT NULL,
  fecha_creacion datetime NOT NULL,
  usr_creacion decimal(10,0) NOT NULL,
  fecha_ult_modificacion datetime NOT NULL,
  usr_ult_modificacion decimal(10,0) NOT NULL,
  activo char(1) NOT NULL,
  PRIMARY KEY  (id_detalle_percepciones_compra),
  KEY id_factura (id_compra),
  KEY id_retencion (id_retencion)
) ;


insert into funcion values (23, 'Consulta Comprobante AFIP', 'CONSULTAAFIP', 2, 'S', sysdate(), 1, sysdate(), 1, 'S');
