--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_preguntas_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_preguntas_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigefo.tpreguntas'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sigefo.ft_preguntas_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_PRE_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		JUAN	
 	#FECHA:		20-04-2017 00:51:06
	***********************************/

	if(p_transaccion='SIGEFO_PRE_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pre.id_pregunta,
						pre.id_categoria,
						pre.tipo,
						pre.pregunta,
						pre.habilitado,
						pre.estado_reg,
						pre.id_usuario_ai,
						pre.id_usuario_reg,
						pre.usuario_ai,
						pre.fecha_reg,
						pre.fecha_mod,
						pre.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        c.categoria,
                        c.tipo as tipocat
						from sigefo.tpreguntas pre
						inner join segu.tusuario usu1 on usu1.id_usuario = pre.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pre.id_usuario_mod
                        INNER JOIN sigefo.tcategoria c ON c.id_categoria= pre.id_categoria
				        where';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	
   /*********************************    
 	#TRANSACCION:  'SIGEFO_PRE_PRO_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:06
	***********************************/

	ELSEIF(p_transaccion='SIGEFO_PRE_PRO_SEL')THEN     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pre.id_pregunta,
						pre.id_categoria,
						pre.tipo,
						pre.pregunta,
						pre.habilitado,
						pre.seccion,
						pre.estado_reg,
						pre.id_usuario_ai,
						pre.id_usuario_reg,
						pre.usuario_ai,
						pre.fecha_reg,
						pre.fecha_mod,
						pre.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        c.categoria,
                        c.tipo as tipocat
						from sigefo.tpreguntas pre
						inner join segu.tusuario usu1 on usu1.id_usuario = pre.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pre.id_usuario_mod
                        INNER JOIN sigefo.tcategoria c ON c.id_categoria= pre.id_categoria
				        where c.tipo= ''Proveedor'' AND pre.habilitado= true AND';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
	END;			

	/*********************************    
 	#TRANSACCION:  'SIGEFO_PRE_PRO_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:06
	***********************************/

	elsif(p_transaccion='SIGEFO_PRE_PRO_CONT')then	

		begin
			--Sentencia de la consulta de conteo de registros
            
			v_consulta:='select count(id_pregunta)
					    from sigefo.tpreguntas pre
					    inner join segu.tusuario usu1 on usu1.id_usuario = pre.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pre.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
        
    /*********************************    
 	#TRANSACCION:  'SIGEFO_PRE_FUN_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:06
	***********************************/

	ELSEIF(p_transaccion='SIGEFO_PRE_FUN_SEL')THEN     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pre.id_pregunta,
						pre.id_categoria,
						pre.tipo,
						pre.pregunta,
						pre.habilitado,
						pre.seccion,
						pre.estado_reg,
						pre.id_usuario_ai,
						pre.id_usuario_reg,
						pre.usuario_ai,
						pre.fecha_reg,
						pre.fecha_mod,
						pre.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        c.categoria,
                        c.tipo as tipocat
						from sigefo.tpreguntas pre
						inner join segu.tusuario usu1 on usu1.id_usuario = pre.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pre.id_usuario_mod
                        INNER JOIN sigefo.tcategoria c ON c.id_categoria= pre.id_categoria
				        where c.tipo= ''Funcionario'' AND pre.habilitado= true AND';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
	END;			

	/*********************************    
 	#TRANSACCION:  'SIGEFO_PRE_FUN_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:06
	***********************************/

	elsif(p_transaccion='SIGEFO_PRE_FUN_CONT')then	

		begin
			--Sentencia de la consulta de conteo de registros
            
			v_consulta:='select count(id_pregunta)
					    from sigefo.tpreguntas pre
					    inner join segu.tusuario usu1 on usu1.id_usuario = pre.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pre.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;    
        
	/*********************************    
 	#TRANSACCION:  'SIGEFO_PRE_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		20-04-2017 00:51:06
	***********************************/

	elsif(p_transaccion='SIGEFO_PRE_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pregunta)
					    from sigefo.tpreguntas pre
					    inner join segu.tusuario usu1 on usu1.id_usuario = pre.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = pre.id_usuario_mod
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