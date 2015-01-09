DROP TABLE  FUNCION_PANTALLA;
DROP TABLE  FACTURA_LOTE;
DROP TABLE  LICENCIA;
DROP TABLE  ROL_FUNCION;
DROP TABLE  USUARIO_ROL_EMPRESA;

DROP TABLE  FACTURA;
DROP TABLE  FUNCION;
DROP TABLE  ROL;
DROP TABLE  USUARIO;
DROP TABLE  PANTALLA;
DROP TABLE  MODULO;
DROP TABLE  CLIENTE;
DROP TABLE  REGISTRO;
DROP TABLE  TIPO_MOVIMIENTO;
DROP TABLE  LOTE;
DROP TABLE  ESTADO_LOTE;
DROP TABLE  TIPO_COMPROBANTE;
DROP TABLE  EMPRESA;
DROP TABLE  TIPO_DOCUMENTO;
DROP TABLE  PROVINCIA;
DROP TABLE  PAIS;


CREATE TABLE PROVINCIA
(
	id_provincia NUMBER(12,0) NOT NULL,
  id_pais NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(50) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_provincia)
) ;


CREATE TABLE PAIS
(
	id_pais NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(50) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_pais)
) ;


CREATE TABLE ESTADO_LOTE
(
	id_estado_lote NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(50) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_crecion NUMBER(12,0) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_utl_modificacion NUMBER(12,0) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_estado_lote)
) ;


CREATE TABLE LICENCIA
(
	id_empresa NUMBER(12,0) NOT NULL,
	id_modulo NUMBER(12,0) NOT NULL,
	fecha_desde_validez DATE NOT NULL,
	fecha_hasta_validez DATE NOT NULL,
  clave VARCHAR2(250) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(12,0) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(12,0) NOT NULL,
	activo CHAR(1),
	PRIMARY KEY (id_empresa, id_modulo)
) ;


CREATE TABLE MODULO
(
	id_modulo NUMBER(12,0) NOT NULL,
	nombre CHAR(20) NOT NULL,
	nombre_corto CHAR(5) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(12,0) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(12,0) NOT NULL,
	activo CHAR(1),
	PRIMARY KEY (id_modulo)
) ;


CREATE TABLE CLIENTE
(
	id_cliente NUMBER(12,0) NOT NULL,
	razon_social CHAR(60) NOT NULL,
	id_tipo_documento NUMBER(12,0),
	nro_documento NUMBER(11),
	email CHAR(60),
	calle CHAR(30),
	numero NUMBER(5),
	piso NUMBER(2),
	departamento CHAR(5),
	codigo_postal CHAR(8),
	ciudad CHAR(30),
	id_provincia NUMBER(12,0) default 0 not null,
	id_pais NUMBER(12,0) default 0 not null,
	imprimir_factura CHAR(1) default 'S' NOT NULL,
	enviar_factura_electronica  CHAR(1) default 'S' NOT NULL,
	telefono VARCHAR2(20),
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(12,0) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(12,0) NOT NULL,
	activo CHAR(1),
	PRIMARY KEY (id_cliente)
) ;


CREATE TABLE REGISTRO
(
	id_registro NUMBER(12,0) NOT NULL,
	id_tipo_movimiento NUMBER(12,0) NOT NULL,
	id_lote NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(250) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_registro)
) ;


CREATE TABLE TIPO_MOVIMIENTO
(
	id_tipo_movimiento NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(250) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_tipo_movimiento)
) ;


CREATE TABLE TIPO_DOCUMENTO
(
	id_tipo_documento NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(50) NOT NULL,
	cod_doc_afip VARCHAR2(50) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_tipo_documento)
) ;


CREATE TABLE TIPO_COMPROBANTE
(
	id_tipo_comprobante NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(55) NOT NULL,
	cod_comprobante NUMBER(10) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_tipo_comprobante)
) ;


CREATE TABLE LOTE
(
	id_lote NUMBER(12,0) NOT NULL,
	fecha DATE NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	id_estado_lote NUMBER(12,0) NOT NULL,
	cae VARCHAR2(14),
	PRIMARY KEY (id_lote)
) ;


CREATE TABLE FACTURA_LOTE
(
	id_factura NUMBER(12,0) NOT NULL,
	id_lote NUMBER(12,0) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_factura, id_lote)
) ;


CREATE TABLE EMPRESA
(
	id_empresa NUMBER(12,0) NOT NULL,
	id_tipo_documento NUMBER(12,0) NOT NULL,
	nro_documento NUMBER(11) NOT NULL,
	nombre VARCHAR2(50) NOT NULL,
	calle VARCHAR2(50),
	numero NUMBER(12,0),
	piso NUMBER(12,0),
	departamento VARCHAR2(50),
	codigo_postal NUMBER(12,0),
	ciudad VARCHAR2(50),
	id_provincia NUMBER(12,0),
	id_pais NUMBER(12,0),
	telefono VARCHAR2(20),
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_empresa)
) ;


CREATE TABLE FACTURA
(
	id_factura NUMBER(12,0) NOT NULL,
	id_tipo_documento_cli NUMBER(12,0) NOT NULL,
	id_tipo_comprobante NUMBER(10) NOT NULL,
	pto_vta NUMBER(4) NOT NULL,
	nro_factura NUMBER(8) NOT NULL,
	total NUMBER(10,2) NOT NULL,
	importe_neto_gravado NUMBER(10,2) NOT NULL,
	impuesto_liquidado NUMBER(10,2) NOT NULL,
	impuesto_liquidado_rni NUMBER(10,2) NOT NULL,
	importe_ope_exentas NUMBER(10,2) NOT NULL,
	fec_serv_desde DATE NULL,
	fec_serv_hasta DATE NULL,
	fecha_venc_pago DATE NOT NULL,
	fec_cbte DATE NOT NULL,
	presta_serv CHAR(1) NOT NULL,
	id_empresa NUMBER(12,0) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	id_cliente NUMBER(12,0),
	PRIMARY KEY (id_factura)
) ;


CREATE TABLE PANTALLA
(
	id_pantalla NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(50) NOT NULL,
	valor VARCHAR2(50) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_pantalla)
) ;


CREATE TABLE FUNCION_PANTALLA
(
	id_funcion NUMBER(12,0) NOT NULL,
	id_pantalla NUMBER(12,0) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_funcion, id_pantalla)
) ;


CREATE TABLE FUNCION
(
	id_funcion NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(50) NOT NULL,
	valor VARCHAR2(50) NOT NULL,
	id_modulo NUMBER(12,0) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_funcion)
) ;


CREATE TABLE ROL_FUNCION
(
	id_rol NUMBER(12,0) NOT NULL,
	id_funcion NUMBER(12,0) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_rol, id_funcion)
) ;


CREATE TABLE USUARIO_ROL_EMPRESA
(
	id_usuario NUMBER(12,0) NOT NULL,
	id_rol NUMBER(12,0) NOT NULL,
	id_empresa NUMBER(12,0) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_usuario, id_rol, id_empresa)
) ;


CREATE TABLE ROL
(
	id_rol NUMBER(12,0) NOT NULL,
	descripcion VARCHAR2(50) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_rol)
) ;


CREATE TABLE USUARIO
(
	id_usuario NUMBER(12,0) NOT NULL,
	nombre VARCHAR2(50) NOT NULL,
	apellido VARCHAR2(50) NOT NULL,
	login VARCHAR2(50) NOT NULL,
	password VARCHAR2(50) NOT NULL,
	fecha_creacion DATE NOT NULL,
	usr_creacion NUMBER(10) NOT NULL,
	fecha_ult_modificacion DATE NOT NULL,
	usr_ult_modificacion NUMBER(10) NOT NULL,
	activo CHAR(1) NOT NULL,
	PRIMARY KEY (id_usuario)
) ;






ALTER TABLE LICENCIA ADD CONSTRAINT FK_LICENCIA_MODULO 
	FOREIGN KEY (id_modulo) REFERENCES MODULO (id_modulo);

ALTER TABLE CLIENTE ADD CONSTRAINT FK_CLIENTE_PAIS 
	FOREIGN KEY (id_pais) REFERENCES PAIS (id_pais);

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

ALTER TABLE FACTURA_LOTE ADD CONSTRAINT FK_FACTURA_LOTE_FACTURA
	FOREIGN KEY (id_factura) REFERENCES FACTURA (id_factura);

ALTER TABLE FACTURA_LOTE ADD CONSTRAINT FK_FACTURA_LOTE_LOTE
	FOREIGN KEY (id_lote) REFERENCES LOTE (id_lote);

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