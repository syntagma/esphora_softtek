/* borrado de datos de seteo inicial */
update usuario set activo = 'N' where id_usuario = 1;
update empresa set activo = 'N' where id_empresa = 1;
update rol set activo = 'N' where id_rol = 1;

update usuario_rol_empresa set activo = 'N' where id_usuario = 1 and id_rol = 1 and id_empresa = 1;
update rol_funcion set activo = 'N' where id_rol = 1;
delete from licencia;

/*************************/