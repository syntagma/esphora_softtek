/*use esphora_softtek_prod;*/


DROP TABLE IF EXISTS FUNCION_PANTALLA;
DROP TABLE IF EXISTS FACTURA_LOTE;
DROP TABLE IF EXISTS LICENCIA;
DROP TABLE IF EXISTS ROL_FUNCION;
DROP TABLE IF EXISTS USUARIO_ROL_EMPRESA;

DROP TABLE IF EXISTS RETENCION;
DROP TABLE IF EXISTS DETALLE_PERCEPCIONES_FACTURA;

DROP TABLE IF EXISTS FACTURA;
DROP TABLE IF EXISTS FUNCION;
DROP TABLE IF EXISTS ROL;
DROP TABLE IF EXISTS USUARIO;
DROP TABLE IF EXISTS PANTALLA;
DROP TABLE IF EXISTS MODULO;
DROP TABLE IF EXISTS CLIENTE;
DROP TABLE IF EXISTS REGISTRO;
DROP TABLE IF EXISTS TIPO_MOVIMIENTO;
DROP TABLE IF EXISTS MONEDA;
DROP TABLE IF EXISTS UNIDAD_MEDIDA;
DROP TABLE IF EXISTS LOTE;
DROP TABLE IF EXISTS ESTADO_LOTE;
DROP TABLE IF EXISTS TIPO_COMPROBANTE;
DROP TABLE IF EXISTS EMPRESA;
DROP TABLE IF EXISTS TIPO_DOCUMENTO;
DROP TABLE IF EXISTS PROVINCIA;
DROP TABLE IF EXISTS PAIS;


DROP TABLE IF EXISTS ALICUOTA_IVA;
DROP TABLE IF EXISTS CONDICION_IVA;
DROP TABLE IF EXISTS CONDICION_VENTA;

DROP TABLE IF EXISTS MOTIVO_RECHAZO;
DROP TABLE IF EXISTS FACTURA_MOTIVO_RECHAZO;

DROP TABLE IF EXISTS PUNTO_VENTA;
DROP TABLE IF EXISTS DETALLE_FACTURA;

CREATE TABLE MOTIVO_RECHAZO
(
  id_motivo_rechazo BIGINT NOT NULL,
  cod_motivo_rechazo BIGINT NOT NULL,
  descripcion VARCHAR(250) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_motivo_rechazo)
) ;

CREATE TABLE PROVINCIA
(
	id_provincia BIGINT NOT NULL,
  id_pais BIGINT NOT NULL,
	descripcion VARCHAR(50) NOT NULL,
  cod_afip char(2) not null,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_provincia)
) ;


CREATE TABLE PAIS
(
	id_pais BIGINT NOT NULL,
	descripcion VARCHAR(50) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_pais)
) ;


CREATE TABLE ESTADO_LOTE
(
	id_estado_lote BIGINT NOT NULL,
	descripcion VARCHAR(50) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_crecion BIGINT NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_utl_modificacion BIGINT NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_estado_lote)
) ;


CREATE TABLE LICENCIA
(
	id_empresa BIGINT NOT NULL,
	id_modulo BIGINT NOT NULL,
	fecha_desde_validez DATE NOT NULL,
	fecha_hasta_validez DATE NOT NULL,
  clave varchar(250) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion BIGINT NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion BIGINT NOT NULL,
	activo CHAR(1),
	PRIMARY KEY (id_empresa, id_modulo),
	KEY (id_modulo)
) ;


CREATE TABLE MODULO
(
	id_modulo BIGINT NOT NULL,
	nombre CHAR(20) NOT NULL,
	nombre_corto CHAR(5) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion BIGINT NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion BIGINT NOT NULL,
	activo CHAR(1),
	PRIMARY KEY (id_modulo)
) ;


CREATE TABLE CLIENTE
(
	id_cliente BIGINT NOT NULL,
	razon_social CHAR(60) NOT NULL,
	id_tipo_documento BIGINT NOT NULL,
  id_condicion_iva BIGINT NOT NULL,
	nro_documento NUMERIC(11),
	email CHAR(60),
	calle CHAR(30),
	numero NUMERIC(5),
	piso NUMERIC(2),
	departamento CHAR(5),
	codigo_postal CHAR(8),
	ciudad CHAR(30),
	id_provincia BIGINT default 0 not null,
	id_pais BIGINT default 0 not null,
	imprimir_factura CHAR(1) default 'S' NOT NULL,
	enviar_factura_electronica  CHAR(1) default 'S' NOT NULL,
	telefono VARCHAR(20),
	fecha_creacion DATETIME NOT NULL,
	usr_creacion BIGINT NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion BIGINT NOT NULL,
	activo CHAR(1),
	PRIMARY KEY (id_cliente),
	KEY (id_pais),
	KEY (id_provincia),
	KEY (id_tipo_documento),
  KEY (id_condicion_iva)
) ;


CREATE TABLE REGISTRO
(
	id_registro BIGINT NOT NULL,
	id_tipo_movimiento BIGINT NOT NULL,
	id_lote BIGINT NOT NULL,
	descripcion VARCHAR(250) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_registro),
	KEY (id_lote),
	KEY (id_tipo_movimiento)
) ;


CREATE TABLE TIPO_MOVIMIENTO
(
	id_tipo_movimiento BIGINT NOT NULL,
	descripcion VARCHAR(250) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_tipo_movimiento)
) ;

CREATE TABLE MONEDA
(
	id_moneda BIGINT NOT NULL,
	codigo VARCHAR(3) NOT NULL,
	descripcion VARCHAR(250) NOT NULL,
	codigo_moneda_afip varchar(3) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_moneda)
) ;

CREATE TABLE UNIDAD_MEDIDA
(
	id_unidad_medida BIGINT NOT NULL,
	descripcion VARCHAR(250) NOT NULL,
	codigo_unidad_medida_afip varchar(3) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_unidad_medida)
) ;

CREATE TABLE TIPO_DOCUMENTO
(
	id_tipo_documento BIGINT NOT NULL,
	descripcion VARCHAR(50) NOT NULL,
	cod_doc_afip VARCHAR(50) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_tipo_documento)
) ;


CREATE TABLE  TIPO_COMPROBANTE (
  id_tipo_comprobante bigint(20) NOT NULL,
  descripcion varchar(100) NOT NULL,
  cod_comprobante decimal(10,0) NOT NULL,
  nombre_corto varchar(45) NOT NULL,
  letra char(1) NOT NULL default '',
  fecha_creacion datetime NOT NULL,
  usr_creacion decimal(10,0) NOT NULL,
  fecha_ult_modificacion datetime NOT NULL,
  usr_ult_modificacion decimal(10,0) NOT NULL,
  activo char(1) NOT NULL,
  PRIMARY KEY  (`id_tipo_comprobante`)
) ;


CREATE TABLE PUNTO_VENTA
(
	id_punto_venta BIGINT NOT NULL,
	numero numeric(4) NOT NULL,
  tipo_pto_vta CHAR(1) NOT NULL DEFAULT 'E',
  cai VARCHAR(45),
  fec_venc_cai DATE,
  id_empresa BIGINT NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_punto_venta),
	KEY (id_empresa)
) ;

alter table PUNTO_VENTA add constraint chk_tipoptovta check tipo_pto_vta in ('E', 'A', 'M');


CREATE TABLE LOTE
(
	id_lote BIGINT NOT NULL,
	fecha DATETIME NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	id_estado_lote BIGINT NOT NULL,
  	mensaje_error VARCHAR(255) NOT NULL DEFAULT ' ',
	PRIMARY KEY (id_lote),
	KEY (id_estado_lote)
) ;


CREATE TABLE FACTURA_MOTIVO_RECHAZO
(
  id_motivo_rechazo BIGINT NOT NULL,
  id_factura BIGINT NOT NULL,
	PRIMARY KEY (id_motivo_rechazo, id_factura)
);

CREATE TABLE FACTURA_LOTE
(
	id_factura BIGINT NOT NULL,
	id_lote BIGINT NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_factura, id_lote),
	KEY (id_factura),
	KEY (id_lote)
) ;


CREATE TABLE EMPRESA
(
	id_empresa BIGINT NOT NULL,
  id_moneda BIGINT NOT NULL,
  id_tipo_documento BIGINT NOT NULL,
	nro_documento NUMERIC(11) NOT NULL,
	nombre VARCHAR(50) NOT NULL,
	calle VARCHAR(50),
	numero BIGINT,
	piso BIGINT,
	departamento VARCHAR(50),
	codigo_postal BIGINT,
	ciudad VARCHAR(50),
	id_provincia BIGINT,
	id_pais BIGINT,
	telefono VARCHAR(20),
  fecha_inicio_actividades DATETIME,
  ingresos_brutos CHAR(11),
  nombre_fantasia VARCHAR(250),
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_empresa),
  KEY (id_moneda),
	KEY (id_pais),
	KEY (id_provincia),
	KEY (id_tipo_documento)
) ;


CREATE TABLE FACTURA
(
	id_factura BIGINT NOT NULL,
	id_tipo_comprobante NUMERIC(10) NOT NULL,
  	id_condicion_venta BIGINT NOT NULL,
	id_punto_venta BIGINT NOT NULL,
	nro_factura NUMERIC(8) NOT NULL,
	total NUMERIC(10,2) NOT NULL,
	importe_neto_gravado NUMERIC(10,2) NOT NULL,
	impuesto_liquidado NUMERIC(10,2) NOT NULL,
	impuesto_liquidado_rni NUMERIC(10,2) NOT NULL,
	importe_ope_exentas NUMERIC(10,2) NOT NULL,
  	otros_conceptos NUMERIC(10,2) NOT NULL,
	fec_serv_desde DATE NULL,
	fec_serv_hasta DATE NULL,
	fecha_venc_pago DATE NOT NULL,
	fec_cbte DATE NOT NULL,
	fec_registro_contable DATE NOT NULL,
	presta_serv CHAR(1) NOT NULL,
  	detallada CHAR(1) NOT NULL DEFAULT 'N',
  	retenciones CHAR(1) NOT NULL DEFAULT 'N',
  	id_empresa BIGINT NOT NULL,
	id_cliente BIGINT NOT NULL,
	cae VARCHAR(45) NOT NULL DEFAULT ' ',
	id_moneda BIGINT NOT NULL,
	comentarios VARCHAR(255) default NULL,
  cotizacion DECIMAL(10,5) NOT NULL
  id_afip DECIMAL(15) default null,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_factura),
	KEY (id_cliente),
	KEY (id_empresa),
  KEY (id_tipo_comprobante),
  KEY (id_condicion_venta)
) ;


CREATE TABLE  RETENCION (
  id_retencion bigint NOT NULL,
  descripcion varchar(45) NOT NULL,
  tipo_retencion char(1) not null default 'N',
  compra_venta char(1) not null default 'X',
  fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
  PRIMARY KEY  (`id_retencion`)
) ;
ALTER TABLE RETENCION ADD CONSTRAINT chk_tipo_retencion CHECK tipo_retencion IN ('N', 'M', 'I', 'P');
ALTER TABLE RETENCION ADD CONSTRAINT chk_compra_venta CHECK tipo_retencion IN ('C', 'V', 'X');


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




CREATE TABLE PANTALLA
(
	id_pantalla BIGINT NOT NULL,
	descripcion VARCHAR(50) NOT NULL,
	valor VARCHAR(50) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_pantalla)
) ;


CREATE TABLE FUNCION_PANTALLA
(
	id_funcion BIGINT NOT NULL,
	id_pantalla BIGINT NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_funcion, id_pantalla),
	KEY (id_funcion),
	KEY (id_pantalla)
) ;


CREATE TABLE FUNCION
(
	id_funcion BIGINT NOT NULL,
	descripcion VARCHAR(50) NOT NULL,
	valor VARCHAR(50) NOT NULL,
	id_modulo BIGINT NOT NULL,
	muestra_menu CHAR(1),
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_funcion),
	KEY (id_modulo)
) ;


CREATE TABLE ROL_FUNCION
(
	id_rol BIGINT NOT NULL,
	id_funcion BIGINT NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_rol, id_funcion),
	KEY (id_funcion),
	KEY (id_rol)
) ;


CREATE TABLE USUARIO_ROL_EMPRESA
(
	id_usuario BIGINT NOT NULL,
	id_rol BIGINT NOT NULL,
	id_empresa BIGINT NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_usuario, id_rol, id_empresa),
	KEY (id_empresa),
	KEY (id_rol),
	KEY (id_usuario)
) ;


CREATE TABLE ROL
(
	id_rol BIGINT NOT NULL,
	descripcion VARCHAR(50) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_rol)
) ;


CREATE TABLE USUARIO
(
	id_usuario BIGINT NOT NULL,
	nombre VARCHAR(50) NOT NULL,
	apellido VARCHAR(50) NOT NULL,
	login VARCHAR(50) NOT NULL,
	password VARCHAR(50) NOT NULL,
	fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_usuario)
) ;


CREATE TABLE  ALICUOTA_IVA (
  id_alicuota_iva bigint NOT NULL,
  descripcion varchar(45) NOT NULL,
  tipo_iva char(1) NOT NULL,
  porcentaje decimal(5,2) NOT NULL,
  fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
  PRIMARY KEY  (id_alicuota_iva)
);
ALTER TABLE ALICUOTA_IVA ADD CONSTRAINT chk_tipo_iva CHECK tipo_iva IN ('E', 'G', 'N');


CREATE TABLE  CONDICION_IVA (
  id_condicion_iva bigint NOT NULL,
  descripcion varchar(45) NOT NULL,
	codigo_afip bigint NOT NULL,
  fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
  PRIMARY KEY  (id_condicion_iva)
);

CREATE TABLE  CONDICION_VENTA (
  id_condicion_venta bigint NOT NULL,
  descripcion varchar(45) NOT NULL,
  fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
  PRIMARY KEY  (id_condicion_venta)
);

CREATE TABLE DETALLE_FACTURA (
  id_detalle_factura BIGINT NOT NULL,
  id_factura BIGINT UNSIGNED NOT NULL,
  concepto VARCHAR(250) NOT NULL,
  cantidad DOUBLE NOT NULL,
  id_unidad_medida BIGINT NOT NULL,
  precio_unitario DOUBLE NOT NULL,
  id_alicuota_iva BIGINT UNSIGNED NOT NULL,
  fecha_creacion DATETIME NOT NULL,
	usr_creacion NUMERIC(10) NOT NULL,
	fecha_ult_modificacion DATETIME NOT NULL,
	usr_ult_modificacion NUMERIC(10) NOT NULL,
	activo CHAR(1) NOT NULL,
  PRIMARY KEY (id_detalle_factura),
  KEY (id_factura),
  KEY (id_alicuota_iva),
  KEY (id_unidad_medida)
);

ALTER TABLE DETALLE_FACTURA ADD CONSTRAINT FK_DETFAC_UNIMED
	FOREIGN KEY (id_unidad_medida) REFERENCES UNIDAD_MEDIDA (id_unidad_medida);

ALTER TABLE DETALLE_FACTURA ADD CONSTRAINT FK_DETFAC_FACTURA
	FOREIGN KEY (id_factura) REFERENCES FACTURA (id_factura);

ALTER TABLE DETALLE_FACTURA ADD CONSTRAINT FK_DETFAC_ALIIVA
	FOREIGN KEY (id_alicuota_iva) REFERENCES FACTURA (id_alicuota_iva);

ALTER TABLE LICENCIA ADD CONSTRAINT FK_LICENCIA_MODULO
	FOREIGN KEY (id_modulo) REFERENCES MODULO (id_modulo);

ALTER TABLE CLIENTE ADD CONSTRAINT FK_CLIENTE_PAIS
	FOREIGN KEY (id_pais) REFERENCES PAIS (id_pais);

ALTER TABLE CLIENTE ADD CONSTRAINT FK_CLIENTE_CONDIVA
	FOREIGN KEY (id_condicion_iva) REFERENCES CONDICION_IVA (id_condicion_iva);

ALTER TABLE CLIENTE ADD CONSTRAINT FK_CLIENTE_PROVINCIA
	FOREIGN KEY (id_provincia) REFERENCES PROVINCIA (id_provincia);

ALTER TABLE CLIENTE ADD CONSTRAINT FK_CLIENTE_TIPO_DOCUMENTO
	FOREIGN KEY (id_tipo_documento) REFERENCES TIPO_DOCUMENTO (id_tipo_documento);

ALTER TABLE REGISTRO ADD CONSTRAINT FK_REGISTRO_LOTE
	FOREIGN KEY (id_lote) REFERENCES LOTE (id_lote);

ALTER TABLE REGISTRO ADD CONSTRAINT FK_REGISTRO_TIPO_MOVIMIENTO
	FOREIGN KEY (id_tipo_movimiento) REFERENCES TIPO_MOVIMIENTO (id_tipo_movimiento);

ALTER TABLE LOTE ADD CONSTRAINT FK_LOTE_ESTADO_LOTE
	FOREIGN KEY (id_estado_lote) REFERENCES ESTADO_LOTE (id_estado_lote);

ALTER TABLE FACTURA_MOTIVO_RECHAZO ADD CONSTRAINT FK_FMR_MOTIVORECHAZO
  FOREIGN KEY (id_motivo_rechazo) REFERENCES MOTIVO_RECHAZO (id_motivo_rechazo);

ALTER TABLE FACTURA_MOTIVO_RECHAZO ADD CONSTRAINT FK_FMR_LOTE
  FOREIGN KEY (id_factura) REFERENCES FACTURA (id_factura);

ALTER TABLE FACTURA_LOTE ADD CONSTRAINT FK_FACTURA_LOTE_FACTURA
	FOREIGN KEY (id_factura) REFERENCES FACTURA (id_factura);

ALTER TABLE FACTURA_LOTE ADD CONSTRAINT FK_FACTURA_LOTE_LOTE
	FOREIGN KEY (id_lote) REFERENCES LOTE (id_lote);

ALTER TABLE EMPRESA ADD CONSTRAINT FK_EMPRESA_MONEDA
	FOREIGN KEY (id_moneda) REFERENCES MONEDA (id_moneda);

ALTER TABLE EMPRESA ADD CONSTRAINT FK_EMPRESA_PAIS
	FOREIGN KEY (id_pais) REFERENCES PAIS (id_pais);

ALTER TABLE EMPRESA ADD CONSTRAINT FK_EMPRESA_PROVINCIA
	FOREIGN KEY (id_provincia) REFERENCES PROVINCIA (id_provincia);

ALTER TABLE EMPRESA ADD CONSTRAINT FK_EMPRESA_TIPO_DOCUMENTO
	FOREIGN KEY (id_tipo_documento) REFERENCES TIPO_DOCUMENTO (id_tipo_documento);

ALTER TABLE FACTURA ADD CONSTRAINT FK_FACTURA_CLIENTE
	FOREIGN KEY (id_cliente) REFERENCES CLIENTE (id_cliente);

ALTER TABLE FACTURA ADD CONSTRAINT FK_FACTURA_EMPRESA
	FOREIGN KEY (id_empresa) REFERENCES EMPRESA (id_empresa);

ALTER TABLE FACTURA ADD CONSTRAINT FK_FACTURA_PUNTO_VENTA
	FOREIGN KEY (id_punto_venta) REFERENCES PUNTO_VENTA (id_punto_venta);

ALTER TABLE FACTURA ADD CONSTRAINT FK_FACTURA_TIPOCOMP
	FOREIGN KEY (id_tipo_comprobante) REFERENCES TIPO_COMPROBANTE (id_tipo_comprobante);

ALTER TABLE FACTURA ADD CONSTRAINT FK_FACTURA_CONDVENTA
	FOREIGN KEY (id_condicion_venta) REFERENCES CONDICION_VENTA (id_condicion_venta);

ALTER TABLE PUNTO_VENTA ADD CONSTRAINT FK_PUNTO_VENTA_EMPRESA
	FOREIGN KEY (id_empresa) REFERENCES EMPRESA (id_empresa);

ALTER TABLE FUNCION_PANTALLA ADD CONSTRAINT FK_FUNCION_PANTALLA_FUNCION
	FOREIGN KEY (id_funcion) REFERENCES FUNCION (id_funcion);

ALTER TABLE FUNCION_PANTALLA ADD CONSTRAINT FK_FUNCION_PANTALLA_PANTALLA
	FOREIGN KEY (id_pantalla) REFERENCES PANTALLA (id_pantalla);

ALTER TABLE FUNCION ADD CONSTRAINT FK_FUNCION_MODULO
	FOREIGN KEY (id_modulo) REFERENCES MODULO (id_modulo);

ALTER TABLE ROL_FUNCION ADD CONSTRAINT FK_ROL_FUNCION_FUNCION
	FOREIGN KEY (id_funcion) REFERENCES FUNCION (id_funcion);

ALTER TABLE ROL_FUNCION ADD CONSTRAINT FK_ROL_FUNCION_ROL
	FOREIGN KEY (id_rol) REFERENCES ROL (id_rol);

ALTER TABLE USUARIO_ROL_EMPRESA ADD CONSTRAINT FK_USUARIO_ROL_EMPRESA_EMPRESA
	FOREIGN KEY (id_empresa) REFERENCES EMPRESA (id_empresa);

ALTER TABLE USUARIO_ROL_EMPRESA ADD CONSTRAINT FK_USUARIO_ROL_EMPRESA_ROL
	FOREIGN KEY (id_rol) REFERENCES ROL (id_rol);

ALTER TABLE USUARIO_ROL_EMPRESA ADD CONSTRAINT FK_USUARIO_ROL_EMPRESA_USUARIO
	FOREIGN KEY (id_usuario) REFERENCES USUARIO (id_usuario);

ALTER TABLE DETALLE_PERCEPCIONES_FACTURA ADD CONSTRAINT FK_DETPERFAC_RETENCION
	FOREIGN KEY (id_retencion) REFERENCES RETENCION (id_retencion);

ALTER TABLE DETALLE_PERCEPCIONES_FACTURA ADD CONSTRAINT FK_DETPERFAC_FACTURA
	FOREIGN KEY (id_factura) REFERENCES FACTURA (id_factura);