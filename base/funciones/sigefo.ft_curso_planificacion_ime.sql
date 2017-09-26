--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_curso_planificacion_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_curso_planificacion_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigefo.tcurso_planificacion'
 AUTOR: 		 (admin)
 FECHA:	        22-01-2017 21:35:03
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
	v_id_curso_planificacion	integer;
    
    va_id_planificaciones      varchar [];
    v_id_planificacion       integer;
			    
BEGIN

    v_nombre_funcion = 'sigefo.ft_curso_planificacion_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUPL_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		22-01-2017 21:35:03
	***********************************/

	if(p_transaccion='SIGEFO_CUPL_INS')then
					
        begin
          va_id_planificaciones := string_to_array(v_parametros.id_planificaciones, ',');
          FOREACH v_id_planificacion IN ARRAY va_id_planificaciones
          LOOP
        	--Sentencia de la insercion
        	insert into sigefo.tcurso_planificacion(
			id_curso,
			id_planificacion,
			estado_reg,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.id_curso,
            v_id_planificacion :: INTEGER,
			'activo',
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
			);
		  END LOOP;
            
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Curso planificación almacenado(a) con exito (id_curso_planificacion'||v_id_curso_planificacion||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_curso_planificacion',v_id_curso_planificacion::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUPL_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		22-01-2017 21:35:03
	***********************************/

	elsif(p_transaccion='SIGEFO_CUPL_MOD')then

		begin
			--Sentencia de la modificacion
			update sigefo.tcurso_planificacion set
			id_curso = v_parametros.id_curso,
			id_planificacion = v_parametros.id_planificacion,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_curso_planificacion=v_parametros.id_curso_planificacion;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Curso planificación modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_curso_planificacion',v_parametros.id_curso_planificacion::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUPL_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		22-01-2017 21:35:03
	***********************************/

	elsif(p_transaccion='SIGEFO_CUPL_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sigefo.tcurso_planificacion
            where id_curso_planificacion=v_parametros.id_curso_planificacion;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Curso planificación eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_curso_planificacion',v_parametros.id_curso_planificacion::varchar);
              
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