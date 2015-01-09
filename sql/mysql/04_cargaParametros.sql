use esphora_softtek_test;
/*use esphora_softtek_prod;*/

drop table if exists PARAMETROS;
create table PARAMETROS (parametro varchar(50), valor varchar(250), descripcion varchar(250), primary key(parametro));
insert into PARAMETROS(parametro, valor, descripcion) values ('TIPO_DOCUMENTO_DEFAULT', '1', 'Tipo de Documento Default');
insert into PARAMETROS(parametro, valor, descripcion) values ('PAIS_DEFAULT', '1', 'Pais por Default');
insert into PARAMETROS(parametro, valor, descripcion) values ('PROVINCIA_DEFAULT', '1', 'Provincia por Default');
insert into PARAMETROS(parametro, valor, descripcion) values ('PORC_IVA', '0.21', 'Porcentaje de IVA (formato 0.XXXX)');
insert into PARAMETROS(parametro, valor, descripcion) values ('TIPO_COMPROBANTE_DEFAULT', '1', 'Tipo de Comprobante Default');
insert into PARAMETROS(parametro, valor, descripcion) values ('PAGINADO', '20', 'Cantidad de elementos por paginas');
insert into PARAMETROS(parametro, valor, descripcion) values ('PAGINADO_LISTA', '5', 'Cantidad de elementos por paginas en listas navegables');