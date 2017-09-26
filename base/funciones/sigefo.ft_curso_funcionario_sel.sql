--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_curso_funcionario_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_curso_funcionario_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigefo.tcurso_funcionario'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sigefo.ft_curso_funcionario_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUFU_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		26-01-2017 16:26:09
	***********************************/

	if(p_transaccion='SIGEFO_CUFU_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						cufu.id_curso_funcionario,
						cufu.id_curso,
						cufu.id_funcionario,
						cufu.estado_reg,
						cufu.fecha_reg,
						cufu.usuario_ai,
						cufu.id_usuario_reg,
						cufu.id_usuario_ai,
						cufu.fecha_mod,
						cufu.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        PERSON.nombre_completo2 AS desc_person,
                        FUNCIO.codigo
						from sigefo.tcurso_funcionario cufu
						inner join segu.tusuario usu1 on usu1.id_usuario = cufu.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cufu.id_usuario_mod
                        join orga.tfuncionario FUNCIO on FUNCIO.id_funcionario=cufu.id_funcionario
                        join SEGU.vpersona PERSON ON PERSON.id_persona=FUNCIO.id_persona
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
            raise NOTICE '%', v_consulta;
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_CUFU_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		26-01-2017 16:26:09
	***********************************/

	elsif(p_transaccion='SIGEFO_CUFU_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_curso_funcionario)
					    from sigefo.tcurso_funcionario cufu
					    inner join segu.tusuario usu1 on usu1.id_usuario = cufu.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cufu.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
					
	else
					     
		raise exception 'Transaccion inexistente';
					         
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