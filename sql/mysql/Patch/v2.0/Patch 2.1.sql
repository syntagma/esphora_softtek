--COMPRAS---------------
DROP TABLE IF EXISTS PROVEEDOR;

CREATE TABLE  PROVEEDOR (
 id_proveedor bigint(20) NOT NULL,
 razon_social  char(60) NOT NULL,
 id_tipo_documento  bigint(20) NOT NULL,
 id_condicion_iva  bigint(20) NOT NULL,
 nro_documento  decimal(11,0) default NULL,
 email  char(60) default NULL,
 calle  char(30) default NULL,
 numero  decimal(5,0) default NULL,
 piso  decimal(2,0) default NULL,
 departamento char(5) default NULL,
 codigo_postal char(8) default NULL,
 ciudad char(30) default NULL,
 id_provincia bigint(20) NOT NULL default '0',
 id_pais bigint(20) NOT NULL default '0',
 telefono varchar(20) default NULL,
 fecha_creacion datetime NOT NULL,
 usr_creacion bigint(20) NOT NULL,
 fecha_ult_modificacion datetime NOT NULL,
 usr_ult_modificacion bigint(20) NOT NULL,
 activo char(1) default NULL,
 PRIMARY KEY  (id_proveedor),
 KEY id_pais (id_pais),
 KEY id_provincia (id_provincia),
 KEY id_tipo_documento (id_tipo_documento),
 KEY id_condicion_iva (id_condicion_iva)
); 
ALTER TABLE PROVEEDOR ADD INDEX idx_tipo_nro_doc(id_tipo_documento, nro_documento);

DROP TABLE IF EXISTS COMPRA;
CREATE TABLE  COMPRA (
  id_compra bigint(20) NOT NULL,
  id_tipo_comprobante decimal(10,0) NOT NULL,
  id_condicion_venta bigint(20) NOT NULL,
  punto_venta decimal(4,0) NOT NULL,
  nro_factura decimal(8,0) NOT NULL,
  total decimal(10,2) NOT NULL,
  importe_neto_gravado decimal(10,2) NOT NULL,
  impuesto_liquidado decimal(10,2) NOT NULL,
  impuesto_liquidado_rni decimal(10,2) NOT NULL,
  importe_ope_exentas decimal(10,2) NOT NULL,
  perc_iva decimal(10,2),
  perc_impuestos_nacionales decimal(10,2),
  perc_iibb decimal(10,2),
  perc_impuestos_municipales decimal(10,2),
  impuestos_internos decimal(10,2),
  fecha_venc_pago date DEFAULT NULL,
  fec_cbte date NOT NULL,
  fec_registro_contable date NOT NULL,
  detallada char(1) NOT NULL default 'N',
  retenciones char(1) NOT NULL default 'N',
  id_empresa bigint(20) NOT NULL,
  id_proveedor bigint(20) NOT NULL,
  cae varchar(45) NOT NULL default ' ',
  fecha_creacion datetime NOT NULL,
  usr_creacion decimal(10,0) NOT NULL,
  fecha_ult_modificacion datetime NOT NULL,
  usr_ult_modificacion decimal(10,0) NOT NULL,
  activo char(1) NOT NULL,
  id_moneda bigint(20) NOT NULL,
  comentarios varchar(255) default NULL,
  cotizacion decimal(10,5) NOT NULL,
  PRIMARY KEY  (id_compra),
  KEY id_cliente (id_proveedor),
  KEY id_empresa (id_empresa),
  KEY id_tipo_comprobante (id_tipo_comprobante),
  KEY id_condicion_venta (id_condicion_venta)
);

INSERT INTO MODULO VALUES
(4,'Compras','PROV','2009-01-19 00:31:32',1,'2009-01-19 00:31:32',1,'S');

INSERT INTO FUNCION
VALUES(19,'Proveedores','ABMPROVEEDORES',4,'S','2009-01-19 00:31:32',1,'2009-01-19 00:31:32',1,'S');

INSERT INTO FUNCION
VALUES(21,'Importacion de Compras','IMPORTARCOMPRA',4,'S','2009-01-19 00:31:32',1,'2009-01-19 00:31:32',1,'S');

INSERT INTO FUNCION
VALUES(20,'Compras','CONSULTACOMPRA',4,'S','2009-01-19 00:31:32',1,'2009-01-19 00:31:32',1,'S');

------ CONTABILIDAD ---------------------------------------------------
DROP TABLE IF EXISTS PERIODO;

CREATE TABLE  PERIODO (
 id_periodo bigint(20) NOT NULL,
 nombre  char(60) NOT NULL,
 fecha_inicio  date NOT NULL,
 fecha_fin  date NOT NULL,
 estado  char(1) NOT NULL,
 id_empresa bigint(20) not NULL,
 fecha_creacion datetime NOT NULL,
 usr_creacion char(1) NOT NULL,
 fecha_ult_modificacion datetime NOT NULL,
 usr_ult_modificacion bigint(20) NOT NULL,
 activo char(1) default NULL,
 PRIMARY KEY  (id_periodo)
); 

INSERT INTO MODULO VALUES
(5,'Contabilidad','CONT','2009-01-19 00:31:32',1,'2009-01-19 00:31:32',1,'S');

INSERT INTO FUNCION
VALUES(22,'Periodos','ABMPERIODO',5,'S','2009-01-19 00:31:32',1,'2009-01-19 00:31:32',1,'S');

-----------------------------------------------------------------------

/* Cambio factura Electronica por tipo_pto_vta */
ALTER TABLE PUNTO_VENTA DROP COLUMN factura_electronica;
ALTER TABLE PUNTO_VENTA ADD COLUMN tipo_pto_vta CHAR(1) NOT NULL DEFAULT 'E';
ALTER TABLE PUNTO_VENTA ADD CONSTRAINT chk_tipoptovta CHECK tipo_pto_vta IN ('E', 'A', 'M');
/*------------------------------------------------------------------------------------------*/

/* agrego id_afip a la factura */
/*YA EXISTIA **********
ALTER TABLE FACTURA ADD COLUMN id_afip DECIMAL(15) AFTER comentarios;

UPDATE FACTURA
SET id_afip = (
  SELECT CONCAT(PV.numero, RIGHT(CONCAT('00000000', FACTURA.nro_factura), 8))
  FROM PUNTO_VENTA PV
  WHERE PV.id_punto_venta = FACTURA.id_punto_venta
)
WHERE id_afip IS NULL;
***/
/*------------------------------------------------------------------------------------------*/

/* agrego cai y fecha de vencimiento al pto de venta */
ALTER TABLE PUNTO_VENTA ADD COLUMN cai VARCHAR(45) AFTER tipo_pto_vta;
ALTER TABLE PUNTO_VENTA ADD COLUMN fec_venc_cai DATE AFTER cai;
/*------------------------------------------------------------------------------------------*/

/* agrego el id moneda a la empresa */
ALTER TABLE EMPRESA ADD COLUMN id_moneda BIGINT AFTER id_empresa;
UPDATE EMPRESA SET id_moneda = 1;
ALTER TABLE EMPRESA MODIFY COLUMN id_moneda BIGINT NOT NULL;

ALTER TABLE EMPRESA ADD KEY (id_moneda);

ALTER TABLE EMPRESA ADD CONSTRAINT FK_EMPRESA_MONEDA
	FOREIGN KEY (id_moneda) REFERENCES MONEDA (id_moneda);
/*------------------------------------------------------------------------------------------*/

/* agrego la cotizacion a la factura */
ALTER TABLE FACTURA ADD COLUMN cotizacion DECIMAL(10,5) AFTER comentarios;
UPDATE FACTURA SET cotizacion = 0;
ALTER TABLE FACTURA MODIFY COLUMN cotizacion DECIMAL(10,5) NOT NULL;
/*------------------------------------------------------------------------------------------*/


/* agrego tipo de retencion a las retenciones*/
ALTER TABLE RETENCION ADD COLUMN tipo_retencion CHAR(1) NOT NULL DEFAULT 'N' AFTER descripcion;
ALTER TABLE RETENCION ADD COLUMN compra_venta CHAR(1) NOT NULL DEFAULT 'X' AFTER descripcion;
ALTER TABLE RETENCION ADD CONSTRAINT chk_tipo_retencion CHECK tipo_retencion IN ('N', 'M', 'I', 'P');
ALTER TABLE RETENCION ADD CONSTRAINT chk_compra_venta CHECK tipo_retencion IN ('C', 'V', 'X');

UPDATE RETENCION SET compra_venta = 'C' WHERE id_retencion = 2;
UPDATE RETENCION SET tipo_retencion = 'P' WHERE id_retencion = 3;
UPDATE RETENCION SET tipo_retencion = 'I' WHERE id_retencion = 4;
UPDATE RETENCION SET tipo_retencion = 'M' WHERE id_retencion = 5;
/*------------------------------------------------------------------------------------------*/


/* agrego id_provincia al detalle de retenciones*/
ALTER TABLE DETALLE_RETENCION ADD COLUMN id_provincia BIGINT DEFAULT NULL AFTER detalle;

UPDATE DETALLE_RETENCION
SET    id_provincia = 1
WHERE  id_retencion IN (
       SELECT id_retencion
       FROM   RETENCION
       WHERE  tipo_retencion = 'P'
);
ALTER TABLE DETALLE_RETENCION MODIFY COLUMN detalle VARCHAR(45) NULL;
/*------------------------------------------------------------------------------------------*/

/* agrego cod_afip a la provincia*/
ALTER TABLE PROVINCIA ADD COLUMN cod_afip CHAR(2) AFTER descripcion;

UPDATE PROVINCIA SET cod_afip = 'XX';

UPDATE PROVINCIA SET cod_afip = '00' WHERE id_provincia = 1;
UPDATE PROVINCIA SET cod_afip = '01' WHERE id_provincia = 2;
UPDATE PROVINCIA SET cod_afip = '02' WHERE id_provincia = 3;
UPDATE PROVINCIA SET cod_afip = '16' WHERE id_provincia = 4;
UPDATE PROVINCIA SET cod_afip = '17' WHERE id_provincia = 5;
UPDATE PROVINCIA SET cod_afip = '03' WHERE id_provincia = 6;
UPDATE PROVINCIA SET cod_afip = '04' WHERE id_provincia = 7;
UPDATE PROVINCIA SET cod_afip = '05' WHERE id_provincia = 8;
UPDATE PROVINCIA SET cod_afip = '18' WHERE id_provincia = 9;
UPDATE PROVINCIA SET cod_afip = '06' WHERE id_provincia = 10;
UPDATE PROVINCIA SET cod_afip = '21' WHERE id_provincia = 11;
UPDATE PROVINCIA SET cod_afip = '08' WHERE id_provincia = 12;
UPDATE PROVINCIA SET cod_afip = '07' WHERE id_provincia = 13;
UPDATE PROVINCIA SET cod_afip = '19' WHERE id_provincia = 14;
UPDATE PROVINCIA SET cod_afip = '20' WHERE id_provincia = 15;
UPDATE PROVINCIA SET cod_afip = '22' WHERE id_provincia = 16;
UPDATE PROVINCIA SET cod_afip = '09' WHERE id_provincia = 17;
UPDATE PROVINCIA SET cod_afip = '10' WHERE id_provincia = 18;
UPDATE PROVINCIA SET cod_afip = '11' WHERE id_provincia = 19;
UPDATE PROVINCIA SET cod_afip = '23' WHERE id_provincia = 20;
UPDATE PROVINCIA SET cod_afip = '12' WHERE id_provincia = 21;
UPDATE PROVINCIA SET cod_afip = '13' WHERE id_provincia = 22;
UPDATE PROVINCIA SET cod_afip = '24' WHERE id_provincia = 23;
UPDATE PROVINCIA SET cod_afip = '14' WHERE id_provincia = 24;

ALTER TABLE PROVINCIA MODIFY COLUMN cod_afip CHAR(2) NOT NULL;
/*------------------------------------------------------------------------------------------*/

/* agrego fecha contable a la factura */
ALTER TABLE FACTURA ADD COLUMN fec_registro_contable DATE AFTER fec_cbte;
UPDATE FACTURA SET fec_registro_contable = fec_cbte;
ALTER TABLE FACTURA MODIFY COLUMN fec_registro_contable DATE NOT NULL;
/*------------------------------------------------------------------------------------------*/

/* Cambio el nombre de la tabla de detalle de retenciones */
CREATE TABLE DETALLE_PERCEPCIONES_FACTURA (
  id_detalle_percepciones_factura bigint NOT NULL,
  id_factura bigint NOT NULL,
  id_retencion bigint NOT NULL,
  detalle varchar(45),
  id_provincia bigint default null,
  base_imponible decimal(10,2) NOT NULL,
  alicuota decimal(10,2) NOT NULL,
  fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
  PRIMARY KEY  (id_detalle_percepciones_factura),
  KEY(id_factura),
  KEY(id_retencion)
) ;

ALTER TABLE DETALLE_PERCEPCIONES_FACTURA ADD CONSTRAINT FK_DETPERFAC_RETENCION
	FOREIGN KEY (id_retencion) REFERENCES RETENCION (id_retencion);

ALTER TABLE DETALLE_PERCEPCIONES_FACTURA ADD CONSTRAINT FK_DETPERFAC_FACTURA
	FOREIGN KEY (id_factura) REFERENCES FACTURA (id_factura);

INSERT INTO DETALLE_PERCEPCIONES_FACTURA 
	SELECT * FROM DETALLE_RETENCION; 

DROP TABLE DETALLE_RETENCION;
/*------------------------------------------------------------------------------------------*/

/* Agrego el tipo de iva a la alicuota */
ALTER TABLE ALICUOTA_IVA ADD COLUMN tipo_iva CHAR(1) AFTER descripcion;

UPDATE ALICUOTA_IVA SET tipo_iva = 'G';
UPDATE ALICUOTA_IVA SET tipo_iva = 'E' WHERE porcentaje = 0;

INSERT INTO ALICUOTA_IVA (id_alicuota_iva, descripcion, porcentaje, tipo_iva,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
VALUES (4, 'NO GRAVADO', '0', 'N',
sysdate(), 1, sysdate(), 1, 'S');

ALTER TABLE ALICUOTA_IVA MODIFY COLUMN tipo_iva CHAR(1) NOT NULL;

ALTER TABLE ALICUOTA_IVA ADD CONSTRAINT chk_tipo_iva CHECK tipo_iva IN ('E', 'G', 'N');

/****************************************/
/*Agrego Unidad de Medida a la factura*/
ALTER TABLE DETALLE_FACTURA ADD COLUMN id_unidad_medida BIGINT(20);
UPDATE DETALLE_FACTURA set id_unidad_medida = 3;
ALTER TABLE DETALLE_FACTURA MODIFY COLUMN id_unidad_medida CHAR(1) NOT NULL;
