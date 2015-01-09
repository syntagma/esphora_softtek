use esphora_softtek_prod;
/*use esphora_softtek_prod;*/

/*USUARIOS*/
insert into USUARIO(id_USUARIO, nombre, apellido, login, password,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 'Esphora', 'Esphora', 'esphora', '827dba5b4a9d5adf037ad6db9e1ff88f',
sysdate(), 1, sysdate(), 1, 'S');

/*TIPOS DE DOCUMENTO*/
insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(0, 'NO INFORMADO', 'XX',
sysdate(), 1, sysdate(), 1, 'N');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 'CUIT', '80',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2, 'CUIL', '86',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(3, 'CDI', '87',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(4, 'LE', '89',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(5, 'LC', '90',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(6, 'CI Extranjera', '91',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(7, 'En Tramite', '92',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(8, 'Acta Nacimiento', '93',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(9, 'CI Bs.As. RNP', '95',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(10, 'DNI', '96',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(11, 'Pasaporte', '94',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(12, 'CI Policia Federal', '00',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(13, 'CI Buenos Aires', '01',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(14, 'CI Mendoza', '07',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(15, 'CI La Rioja', '08',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(16, 'CI Salta', '09',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(17, 'CI San Juan', '10',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(18, 'CI San Luis', '11',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(19, 'CI Santa FE', '12',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(20, 'CI Santiago del Estero', '13',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(21, 'CI Tucuman', '14',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(22, 'CI Chaco', '16',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(23, 'CI Chubut', '17',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(24, 'CI Formosa', '18',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(25, 'CI Misiones', '19',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_DOCUMENTO(id_TIPO_DOCUMENTO, descripcion, cod_doc_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(26, 'CI Neuquen', '20',
sysdate(), 1, sysdate(), 1, 'S');

/*PAISES*/
insert into PAIS(id_PAIS, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(0, 'NO INFORMADO',
sysdate(), 1, sysdate(), 1, 'N');

insert into PAIS(id_PAIS, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 'Argentina',
sysdate(), 1, sysdate(), 1, 'S');

insert into PAIS(id_PAIS, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2, 'Ecuador',
sysdate(), 1, sysdate(), 1, 'S');




/*PROVINCIAS*/
insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(0, 0, 'NO INFORMADO', 'XX',
sysdate(), 1, sysdate(), 1, 'N');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 1, 'Capital Federal', '00',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2, 1, 'Buenos Aires', '01',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(3, 1, 'Catamarca', '02',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(4, 1, 'Chaco', '16',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(5, 1, 'Chubut', '17',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(6, 1, 'Cordoba', '03',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(7, 1, 'Corrientes', '04',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(8, 1, 'Entre Rios', '05',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(9, 1, 'Formosa', '18',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(10, 1, 'Jujuy', '06',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(11, 1, 'La Pampa', '21',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(12, 1, 'La Rioja', '08',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(13, 1, 'Mendoza', '07',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(14, 1, 'Misiones', '19',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(15, 1, 'Neuquen', '20',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(16, 1, 'Rio Negro', '22',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(17, 1, 'Salta', '09',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(18, 1, 'San Juan', '10',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(19, 1, 'San Luis', '11',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(20, 1, 'Santa Cruz', '23',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(21, 1, 'Santa Fe', '12',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(22, 1, 'Santiago del Estero', '13',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(23, 1, 'Tierra del Fuego', '24',
sysdate(), 1, sysdate(), 1, 'S');

insert into PROVINCIA(id_PROVINCIA, id_PAIS, descripcion, cod_afip
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(24, 1, 'Tucuman', '14',
sysdate(), 1, sysdate(), 1, 'S');


/*MONEDA*/
insert into MONEDA (id_moneda, codigo, descripcion, codigo_moneda_afip, fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 'ARS', 'Peso Argentino', 'PES',
sysdate(), 1, sysdate(), 1, 'S');

insert into MONEDA (id_moneda, codigo, descripcion, codigo_moneda_afip, fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2, 'USD', 'Dolar Estadounidense', 'DOL',
sysdate(), 1, sysdate(), 1, 'S');

/*UNIDAD DE MEDIDA*/
insert into UNIDAD_MEDIDA (id_unidad_medida, descripcion, codigo_unidad_medida_afip, fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 'KILOGRAMO', '01', 
sysdate(), 1, sysdate(), 1, 'S');

insert into UNIDAD_MEDIDA (id_unidad_medida, descripcion, codigo_unidad_medida_afip, fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2, 'METROS', '02', 
sysdate(), 1, sysdate(), 1, 'S');

insert into UNIDAD_MEDIDA (id_unidad_medida, descripcion, codigo_unidad_medida_afip, fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(3, 'OTRAS UNIDADES', '98', 
sysdate(), 1, sysdate(), 1, 'S');

insert into UNIDAD_MEDIDA (id_unidad_medida, descripcion, codigo_unidad_medida_afip, fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(4, 'BONIFICACION', '99', 
sysdate(), 1, sysdate(), 1, 'S');

/*EMPRESAS*/
insert into EMPRESA (id_EMPRESA, id_TIPO_DOCUMENTO, nro_documento, nombre, calle, numero, piso, departamento, codigo_postal, ciudad, id_PROVINCIA, id_PAIS, telefono,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(0, 0, 0, 'NO INFORMADO', ' ', 0, 0, ' ', 0, ' ', 0, 0, ' ',
sysdate(), 1, sysdate(), 1, 'N');


insert into EMPRESA (id_EMPRESA, id_TIPO_DOCUMENTO, nro_documento, nombre, calle, numero, piso, departamento, codigo_postal, ciudad, id_PROVINCIA, id_PAIS, telefono,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 0, 0, 'Administrador', ' ', 0, 0, ' ', 0, ' ', 0, 0, ' ',
sysdate(), 1, sysdate(), 1, 'S');

/*ROLES*/
insert into ROL(id_ROL, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(0, 'NO INFORMADO',
sysdate(), 1, sysdate(), 1, 'N');

insert into ROL(id_ROL, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 'Super Usuario',
sysdate(), 1, sysdate(), 1, 'S');

insert into USUARIO_ROL_EMPRESA(id_USUARIO, id_ROL, id_EMPRESA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 1, 1,
sysdate(), 1, sysdate(), 1, 'S');

/*MODULOS*/
insert into MODULO (id_MODULO, nombre, nombre_corto,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 'Administrador', 'ADMIN',
sysdate(), 1, sysdate(), 1, 'S');

insert into MODULO (id_MODULO, nombre, nombre_corto,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2, 'Facturacion', 'FACT',
sysdate(), 1, sysdate(), 1, 'S');

insert into MODULO (id_MODULO, nombre, nombre_corto,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(3, 'Procesos AFIP', 'AFIP',
sysdate(), 1, sysdate(), 1, 'S');

/*LICENCIAS*/
insert into LICENCIA (id_EMPRESA, id_MODULO, fecha_desde_validez, fecha_hasta_validez, clave,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 1, '20080101', '20081231', 'e50bf3b6b9fe1139c6432974e7b6687f',
sysdate(), 1, sysdate(), 1, 'S');

insert into LICENCIA (id_EMPRESA, id_MODULO, fecha_desde_validez, fecha_hasta_validez, clave,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 2, '20080101', '20081231', '356bba825692ddb8c5064bed9855e9e2',
sysdate(), 1, sysdate(), 1, 'S');

insert into LICENCIA (id_EMPRESA, id_MODULO, fecha_desde_validez, fecha_hasta_validez, clave,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 3, '20080101', '20081231', '73c2ed6f12e3ef0ef06f52b0a51bb5e2',
sysdate(), 1, sysdate(), 1, 'S');

/*FUNCIONES*/
insert into FUNCION(id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 'ABMUSUARIO', 'Usuarios', 1,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION(id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2, 'ABMROL', 'Roles', 1,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION(id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(3, 'ABMEMPRESA', 'Empresas', 1,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION(id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(4, 'ABMTIPOCOMPROBANTE', 'Tipos de Comprobante', 1,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION(id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(5, 'ABMTIPODOCUMENTO', 'Tipos de Documento', 1,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION(id_FUNCION, valor, descripcion, id_MODULO, muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(6, 'ALTAFACTURA', 'Alta de Factura', 2, 'N',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION(id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(7, 'ENVIOAFIP', 'Proceso de Aprobacion AFIP', 3,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (8, 'ALTALOTE', 'Alta de Lote', 2,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (9, 'ABMCLIENTES', 'Clientes', 2,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (10, 'IMPORTARFACTURA', 'Importacion de Facturas', 2,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (11, 'CONSULTAFACTURA', 'Facturas', 2,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (12, 'ABMPUNTOVENTA', 'Puntos de Venta', 2,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (13, 'ABMALICUOTAIVA', 'Alicuotas de Iva', 1,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (14, 'ABMCONDICIONIVA', 'Condiciones de Iva', 1,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (15, 'ABMCONDICIONVENTA', 'Condiciones de Venta', 2,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (16, 'ABMMONEDA', 'Monedas', 1,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (17, 'ABMUNIDADMEDIDA', 'Unidades de Medida', 1,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (18, 'GENERARCD', 'Medios Magneticos', 3,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION (id_FUNCION, valor, descripcion, id_MODULO,muestra_menu,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (23, 'CONSULTAAFIP', 'Consulta Comprobante AFIP', 2,'S',
sysdate(), 1, sysdate(), 1, 'S');

insert into ROL_FUNCION(id_ROL, id_FUNCION,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
select 1, id_FUNCION,
sysdate(), 1, sysdate(), 1, 'S'
from FUNCION;

insert into funcion values (23, 'Consulta AFIP', 'CONSULTAAFIP', 2, 'S', sysdate(), 1, sysdate(), 1, 'S');

/*PANTALLAS*/
insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1, 'LISTUSUARIO', 'Usuarios',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2, 'EDITUSUARIO', 'Edicion de Usuarios',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(3, 'LISTROL', 'Roles',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(4, 'EDITROL', 'Edicion de Roles',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(5, 'LISTEMPRESA', 'Empresas',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(6, 'EDITEMPRESA', 'Edicion de Empresas',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(7, 'LISTTIPOCOMPROBANTE', 'Tipos de Comprobante',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(8, 'EDITTIPOCOMPROBANTE', 'Edicion de Tipos de Comprobante',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(9, 'LISTTIPODOCUMENTO', 'Tipos de Documento',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(10, 'EDITTIPODOCUMENTO', 'Edicion de Tipos de Documento',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(11, 'ALTAFACTURA', 'Alta de Factura',
sysdate(), 1, sysdate(), 1, 'S');

insert into PANTALLA(id_PANTALLA, valor, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(12, 'ENVIOAFIP', 'Proceso de Aprobacion AFIP',
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1,1,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(1,2,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2,3,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(2,4,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(3,5,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(3,6,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(4,7,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(4,8,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(5,9,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(5,10,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(6,11,
sysdate(), 1, sysdate(), 1, 'S');

insert into FUNCION_PANTALLA(id_FUNCION, id_PANTALLA,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values(7,12,
sysdate(), 1, sysdate(), 1, 'S');


/*TIPOS DE COMPROBANTE*/
insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (1, 'Facturas A', '01', 'Factura', 'A',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (2, 'Notas de Debito A', '02', 'Nota de Debito', 'A',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (3, 'Notas de Credito A', '03', 'Nota de Credito', 'A',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (4, 'Recibos A', '04', 'Recibo', 'A',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (5, 'Notas de Venta al contado A', '05', 'Nota de Venta al Contado', 'A',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (6, 'Facturas B', '06', 'Factura', 'B',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (7, 'Notas de Debito B', '07', 'Nota de Debito', 'B',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (8, 'Notas de Credito B', '08', 'Nota de Credito', 'B',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (9, 'Recibos B', '09', 'Recibo', 'B',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (10, 'Notas de Venta al contado B', '10', 'Nota de Venta al contado', 'B',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (11, 'Otros comprobantes A que cumplan con la R.G. N 3419', '39', 'Comprobante', 'A',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (12, 'Otros comprobantes B que cumplan con la R.G. N 3419', '40', 'Comprobante', 'B',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (13, 'Cuenta de Venta y Liquido producto A', '60', 'Cta. de Vta. y Liquido', 'A',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (14, 'Cuenta de Venta y Liquido producto B', '61', 'Cta. de Vta. y Liquido', 'B',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (15, 'Liquidacion A', '63', 'Liquidacion', 'A',
sysdate(), 1, sysdate(), 1, 'S');

insert into TIPO_COMPROBANTE(id_tipo_comprobante, descripcion, cod_comprobante, nombre_corto, letra,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (16, 'Liquidacion B', '64', 'Liquidacion', 'B',
sysdate(), 1, sysdate(), 1, 'S');


/*Alicuota IVA */
insert into ALICUOTA_IVA (id_alicuota_iva, descripcion, porcentaje, tipo_iva,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (1, 'IVA 21%', '0.21', 'G',
sysdate(), 1, sysdate(), 1, 'S');

insert into ALICUOTA_IVA (id_alicuota_iva, descripcion, porcentaje, tipo_iva,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (2, 'IVA 10,5%', '0.105', 'G',
sysdate(), 1, sysdate(), 1, 'S');

insert into ALICUOTA_IVA (id_alicuota_iva, descripcion, porcentaje, tipo_iva,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (3, 'IVA EXENTO', '0', 'E',
sysdate(), 1, sysdate(), 1, 'S');

insert into ALICUOTA_IVA (id_alicuota_iva, descripcion, porcentaje, tipo_iva,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (4, 'NO GRAVADO', '0', 'N',
sysdate(), 1, sysdate(), 1, 'S');

/* Condicion IVA */
insert into CONDICION_IVA (id_condicion_iva, descripcion, codigo_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (1, 'Responsable Inscripto', 1,
sysdate(), 1, sysdate(), 1, 'S');

insert into CONDICION_IVA (id_condicion_iva, descripcion, codigo_afip,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (2, 'Responsable No Inscripto', 2,
sysdate(), 1, sysdate(), 1, 'S');

/* Condicion de Venta */
insert into CONDICION_VENTA (id_condicion_venta, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (1, 'Efectivo',
sysdate(), 1, sysdate(), 1, 'S');

insert into CONDICION_VENTA (id_condicion_venta, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (2, 'Cheque',
sysdate(), 1, sysdate(), 1, 'S');

insert into CONDICION_VENTA (id_condicion_venta, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (3, 'Tarjeta de Credito',
sysdate(), 1, sysdate(), 1, 'S');


/*Motivos de Rechazo */
insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (1,1, 'LA CUIT INFORMADA NO CORRESPONDE A UN RESPONSABLE INSCRIPTO EN EL IVA ACTIVO',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (2,2, 'LA CUIT INFORMADA NO SE ENCUENTRA AUTORIZADA A EMITIR COMPROBANTES ELECTRONICOS ORIGINALES O EL PERIODO DE INICIO AUTORIZADO ES POSTERIOR AL DE LA GENERACION DE LA SOLICITUD',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (3,3, 'LA CUIT INFORMADA REGISTRA INCONVENIENTES CON EL DOMICILIO FISCAL',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (4,4, 'EL PUNTO DE VENTA INFORMADO NO SE ENCUENTRA DECLARADO PARA SER UTILIZADO EN EL PRESENTE REGIMEN',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (5,5, 'LA FECHA DEL COMPROBANTE INDICADA NO PUEDE SER ANTERIOR EN MAS DE CINCO DIAS, SI SE TRATA DE UNA VENTA, O ANTERIOR O POSTERIOR EN MAS DE DIEZ DIAS, SI SE TRATA DE UNA PRESTACION DE SERVICIOS, CONSECUTIVOS DE LA FECHA DE REMISION DEL ARCHIVO',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (6,6, 'LA CUIT INFORMADA NO SE ENCUENTRA AUTORIZADA A EMITIR COMPROBANTES CLASE "A"',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (7,7, 'ARA LA CLASE DE COMPROBANTE SOLICITADO -COMPROBANTE CLASE A- DEBERA CONSIGNAR EN EL CAMPO CODIGO DE DOCUMENTO IDENTIFICATORIO DEL COMPRADOR EL CODIGO "80"',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (8,8, 'LA CUIT INDICADA EN EL CAMPO Nro DE IDENTIFICACION DEL COMPRADOR ES INVALIDA',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (9,9, 'LA CUIT INDICADA EN EL CAMPO Nro DE IDENTIFICACION DEL COMPRADOR NO EXISTE EN EL PADRON UNICO DE CONTRIBUYENTES',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (10,10, 'LA CUIT INDICADA EN EL CAMPO Nro DE IDENTIFICACION DEL COMPRADOR NO CORRESPONDE A UN RESPONSABLE INSCRIPTO EN EL IVA ACTIVO',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (11,11, 'EL Nro DE COMPROBANTE DESDE INFORMADO NO ES CORRELATIVO AL ULTIMO Nro DE COMPROBANTE REGISTRADO/HASTA SOLICITADO PARA ESE TIPO DE COMPROBANTE Y PUNTO DE VENTA',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (12,12, 'EL RANGO INFORMADO SE ENCUENTRA AUTORIZADO CON ANTERIORIDAD PARA LA MISMA CUIT, TIPO DE COMPROBANTE Y PUNTO DE VENTA',
sysdate(), 1, sysdate(), 1, 'S');

insert into MOTIVO_RECHAZO (id_motivo_rechazo, cod_motivo_rechazo, descripcion,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (13,13, 'LA CUIT INDICADA SE ENCUENTRA COMPRENDIDA EN EL REGIMEN ESTABLECIDO POR LA RESOLUCION GENERAL Nro 2177 Y/O EN EL TITULO I DE LA RESOLUCION GENERAL Nro 1361 ART. 24 DE LA RG Nro 2177',
sysdate(), 1, sysdate(), 1, 'S');


/* Retenciones */
insert into RETENCION (id_retencion, descripcion, tipo_retencion, compra_venta,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (1, 'Per./Ret. de Imp. a las Ganancias', 'N', 'X'
sysdate(), 1, sysdate(), 1, 'S');

insert into RETENCION (id_retencion, descripcion, tipo_retencion, compra_venta,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (2, 'Per./Ret. de IVA','N', 'C'
sysdate(), 1, sysdate(), 1, 'S');

insert into RETENCION (id_retencion, descripcion, tipo_retencion, compra_venta,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (3, 'Per./Ret. Ingresos Brutos','P', 'X'
sysdate(), 1, sysdate(), 1, 'S');

insert into RETENCION (id_retencion, descripcion, tipo_retencion, compra_venta,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (4, 'Impuestos Internos','I', 'X'
sysdate(), 1, sysdate(), 1, 'S');

insert into RETENCION (id_retencion, descripcion, tipo_retencion, compra_venta,
fecha_creacion, usr_creacion, fecha_ult_modificacion, usr_ult_modificacion, activo)
values (5, 'Impuestos Municipales','M', 'X'
sysdate(), 1, sysdate(), 1, 'S');


 INSERT INTO ESTADO_LOTE VALUES(1, 'NUEVO', sysdate(), 1, sysdate(), 1, 'S');
 INSERT INTO ESTADO_LOTE VALUES(2, 'CONSULTADO', sysdate(), 1, sysdate(), 1, 'S');
 INSERT INTO ESTADO_LOTE VALUES(3, 'ERROR', sysdate(), 1, sysdate(), 1, 'S');
 INSERT INTO ESTADO_LOTE VALUES(4, 'RECHAZADO', sysdate(), 1, sysdate(), 1, 'S');