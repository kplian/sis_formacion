--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_curso_funcionario_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_curso_funcionario_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigefo.tcurso_funcionario'
 AUTOR: 		 (admin)
 FECHA:	        26-01-2017 16:26:09
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
	v_id_curso_funcionario	integer;
    
    va_id_funcionarios      varchar [];
    v_id_funcionario        integer;
			    
BEGIN

    v_nombre_funcion = 'sigefo.ft_curso_funcionario_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUFU_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-01-2017 16:26:09
	***********************************/

	if(p_transaccion='SIGEFO_CUFU_INS')then
					
        begin
             va_id_funcionarios := string_to_array(v_parametros.id_funcionarios, ',');

      FOREACH v_id_funcionario IN ARRAY va_id_funcionarios
      LOOP
        	--Sentencia de la insercion
        	insert into sigefo.tcurso_funcionario(
			id_curso,
			id_funcionario,
			estado_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_curso,
			v_id_funcionario:: INTEGER,
			'activo',
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null
			);
		 END LOOP;  
        
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Curso funcionario almacenado(a) con exito (id_curso_funcionario'||v_id_curso_funcionario||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_curso_funcionario',v_id_curso_funcionario::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUFU_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-01-2017 16:26:09
	***********************************/

	elsif(p_transaccion='SIGEFO_CUFU_MOD')then

		begin
			--Sentencia de la modificacion
			update sigefo.tcurso_funcionario set
			id_curso = v_parametros.id_curso,
			id_funcionario = v_parametros.id_funcionario,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_curso_funcionario=v_parametros.id_curso_funcionario;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Curso funcionario modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_curso_funcionario',v_parametros.id_curso_funcionario::varchar);
               
            --Devuelve la respuesta
            return v_resp;
		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUFU_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		26-01-2017 16:26:09
	***********************************/

	elsif(p_transaccion='SIGEFO_CUFU_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sigefo.tcurso_funcionario
            where id_curso_funcionario=v_parametros.id_curso_funcionario;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Curso funcionario eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_curso_funcionario',v_parametros.id_curso_funcionario::varchar);
              
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