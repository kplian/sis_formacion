--------------- SQL ---------------
CREATE OR REPLACE FUNCTION sigefo.ft_preguntas_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_preguntas_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigefo.tpreguntas'
 AUTOR: 		 (admin)
 FECHA:	        20-04-2017 00:51:06
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
	v_id_pregunta	integer;
			    
BEGIN

    v_nombre_funcion = 'sigefo.ft_preguntas_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_PRE_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:06
	***********************************/

	if(p_transaccion='SIGEFO_PRE_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sigefo.tpreguntas(
			id_categoria,
			tipo,
			pregunta,
			habilitado,
			estado_reg,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_categoria,
			v_parametros.tipo,
			v_parametros.pregunta,
			v_parametros.habilitado,
			'activo',
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_pregunta into v_id_pregunta;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Preguntas almacenado(a) con exito (id_pregunta'||v_id_pregunta||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pregunta',v_id_pregunta::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_PRE_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:06
	***********************************/

	elsif(p_transaccion='SIGEFO_PRE_MOD')then

		begin
			--Sentencia de la modificacion
			update sigefo.tpreguntas set
			id_categoria = v_parametros.id_categoria,
			tipo = v_parametros.tipo,
			pregunta = v_parametros.pregunta,
			habilitado = v_parametros.habilitado,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_pregunta=v_parametros.id_pregunta;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Preguntas modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pregunta',v_parametros.id_pregunta::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_PRE_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:06
	***********************************/

	elsif(p_transaccion='SIGEFO_PRE_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sigefo.tpreguntas
            where id_pregunta=v_parametros.id_pregunta;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Preguntas eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_pregunta',v_parametros.id_pregunta::varchar);
              
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