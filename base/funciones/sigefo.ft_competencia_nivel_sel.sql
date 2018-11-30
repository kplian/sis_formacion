--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_competencia_nivel_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de competencias
 FUNCION: 		sigefo.ft_competencia_nivel_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigefo.tcompetencia_nivel'
 AUTOR: 		 (jjimenez)
 FECHA:	        11-06-2018 20:42:44
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				11-06-2018 20:42:44								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigefo.tcompetencia_nivel'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sigefo.ft_competencia_nivel_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_COMNIV_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		jjimenez	
 	#FECHA:		11-06-2018 20:42:44
	***********************************/

	if(p_transaccion='SIGEFO_COMNIV_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						comniv.id_competencia_nivel,
						comniv.nivel,
						comniv.id_competencia,
						comniv.estado_reg,
						comniv.id_usuario_ai,
						comniv.fecha_reg,
						comniv.usuario_ai,
						comniv.id_usuario_reg,
						comniv.fecha_mod,
						comniv.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        comniv.descripcion	
						from sigefo.tcompetencia_nivel comniv
						inner join segu.tusuario usu1 on usu1.id_usuario = comniv.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = comniv.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by id_competencia_nivel asc limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            --RAISE notice 'erro %',v_consulta;
            --RAISE EXCEPTION 'erro %',v_consulta;
			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SIGEFO_COMNIV_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		jjimenez	
 	#FECHA:		11-06-2018 20:42:44
	***********************************/

	elsif(p_transaccion='SIGEFO_COMNIV_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_competencia_nivel)
					    from sigefo.tcompetencia_nivel comniv
					    inner join segu.tusuario usu1 on usu1.id_usuario = comniv.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = comniv.id_usuario_mod
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