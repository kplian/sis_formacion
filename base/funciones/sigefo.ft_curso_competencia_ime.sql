CREATE OR REPLACE FUNCTION sigefo.ft_curso_competencia_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_curso_competencia_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigefo.tcurso_competencia'
 AUTOR: 		 (admin)
 FECHA:	        22-01-2017 20:25:54
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
	v_id_curso_competencia	integer;
    
    va_id_competencias      varchar [];
    v_id_competencia        integer;
			    
BEGIN

    v_nombre_funcion = 'sigefo.ft_curso_competencia_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUCO_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		22-01-2017 20:25:54
	***********************************/

	if(p_transaccion='SIGEFO_CUCO_INS')then
					
        begin
           va_id_competencias := string_to_array(v_parametros.id_competencias, ',');
           
      FOREACH v_id_competencia IN ARRAY va_id_competencias
      LOOP
            --Sentencia de la insercion
        	insert into sigefo.tcurso_competencia(
			id_usuario_reg,
            fecha_reg,
            estado_reg,
            id_usuario_ai,
            id_curso,
			id_competencia
            ) 
            values(
            p_id_usuario,
            now(),
            'activo',
            v_parametros._id_usuario_ai,
			v_parametros.id_curso,
            v_id_competencia :: INTEGER
            );
            
      END LOOP;

			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Curso competencia almacenado(a) con exito (id_curso_competencia'||v_id_curso_competencia||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_curso_competencia',v_id_curso_competencia::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUCO_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		22-01-2017 20:25:54
	***********************************/

	elsif(p_transaccion='SIGEFO_CUCO_MOD')then

		begin
			--Sentencia de la modificacion
			update sigefo.tcurso_competencia set
			id_curso = v_parametros.id_curso,
			id_competencia = v_parametros.id_competencia,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_curso_competencia=v_parametros.id_curso_competencia;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Curso competencia modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_curso_competencia',v_parametros.id_curso_competencia::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUCO_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		22-01-2017 20:25:54
	***********************************/

	elsif(p_transaccion='SIGEFO_CUCO_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sigefo.tcurso_competencia
            where id_curso_competencia=v_parametros.id_curso_competencia;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Curso competencia eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_curso_competencia',v_parametros.id_curso_competencia::varchar);
              
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