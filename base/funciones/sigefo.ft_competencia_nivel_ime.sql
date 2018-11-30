--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_competencia_nivel_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de competencias
 FUNCION: 		sigefo.ft_competencia_nivel_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigefo.tcompetencia_nivel'
 AUTOR: 		 (jjimenez)
 FECHA:	        11-06-2018 20:42:44
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				11-06-2018 20:42:44								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigefo.tcompetencia_nivel'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_competencia_nivel	integer;
			    
BEGIN

    v_nombre_funcion = 'sigefo.ft_competencia_nivel_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_COMNIV_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		jjimenez	
 	#FECHA:		11-06-2018 20:42:44
	***********************************/

	if(p_transaccion='SIGEFO_COMNIV_INS')then
					
        begin
        	--Sentencia de la insercion
            --raise exception 'id competencia %',v_parametros.id_competencia;
        	insert into sigefo.tcompetencia_nivel(
			nivel,
			id_competencia,
			estado_reg,
			id_usuario_ai,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod,
            descripcion
          	) values(
			v_parametros.nivel,
			v_parametros.id_competencia,
			'activo',
			v_parametros._id_usuario_ai,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			null,
			null,
            v_parametros.descripcion
							
			
			
			)RETURNING id_competencia_nivel into v_id_competencia_nivel;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Competencia nivel almacenado(a) con exito (id_competencia_nivel'||v_id_competencia_nivel||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_competencia_nivel',v_id_competencia_nivel::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_COMNIV_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		jjimenez	
 	#FECHA:		11-06-2018 20:42:44
	***********************************/

	elsif(p_transaccion='SIGEFO_COMNIV_MOD')then

		begin
			--Sentencia de la modificacion
			update sigefo.tcompetencia_nivel set
			nivel = v_parametros.nivel,
			id_competencia = v_parametros.id_competencia,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            descripcion = v_parametros.descripcion
			where id_competencia_nivel=v_parametros.id_competencia_nivel;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Competencia nivel modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_competencia_nivel',v_parametros.id_competencia_nivel::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_COMNIV_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		jjimenez	
 	#FECHA:		11-06-2018 20:42:44
	***********************************/

	elsif(p_transaccion='SIGEFO_COMNIV_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sigefo.tcompetencia_nivel
            where id_competencia_nivel=v_parametros.id_competencia_nivel;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Competencia nivel eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_competencia_nivel',v_parametros.id_competencia_nivel::varchar);
              
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