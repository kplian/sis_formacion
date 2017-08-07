--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_categoria_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_categoria_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigefo.tcategoria'
 AUTOR: 		 (admin)
 FECHA:	        20-04-2017 00:51:02
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_categoria	integer;
			    
BEGIN

    v_nombre_funcion = 'sigefo.ft_categoria_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CAT_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:02
	***********************************/

	if(p_transaccion='SIGEFO_CAT_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sigefo.tcategoria(
			categoria,
			estado_reg,
			tipo,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod,
            habilitado
          	) values(
			v_parametros.categoria,
			'activo',
			v_parametros.tipo,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null,
			v_parametros.habilitado::BOOLEAN
			)RETURNING id_categoria into v_id_categoria;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Categoria almacenado(a) con exito (id_categoria'||v_id_categoria||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_categoria',v_id_categoria::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CAT_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:02
	***********************************/

	elsif(p_transaccion='SIGEFO_CAT_MOD')then

		begin
			--Sentencia de la modificacion
			update sigefo.tcategoria set
			categoria = v_parametros.categoria,
			tipo = v_parametros.tipo,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            habilitado = v_parametros.habilitado
			where id_categoria=v_parametros.id_categoria;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Categoria modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_categoria',v_parametros.id_categoria::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CAT_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:02
	***********************************/

	elsif(p_transaccion='SIGEFO_CAT_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sigefo.tcategoria
            where id_categoria=v_parametros.id_categoria;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Categoria eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_categoria',v_parametros.id_categoria::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION
				
	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
				        
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;