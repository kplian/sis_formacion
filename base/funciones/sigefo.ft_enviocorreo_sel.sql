CREATE OR REPLACE FUNCTION sigefo.ft_enviocorreo_sel (
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
 EGS
 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_consulta    		varchar;
    v_consulta1    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
    item				record;
    v_fecha				date;
    v_fecha_cadena		varchar;
    
    j_cursos                       JSON;
  	j_id_cursos                    JSON;
    v_id						integer;
    usuario_envio				VARCHAR;
			    
BEGIN

	v_nombre_funcion = 'sigefo.ft_enviocorreo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIGEFO_ENCO_SEL'
 	#DESCRIPCION:	envia correo
 	#AUTOR:		admin	
 	#FECHA:		26-01-2017 16:26:09
	***********************************/

	if(p_transaccion='SIGEFO_ENCO_SEL')then
     				
    	begin
        	j_id_cursos := v_parametros.id_curso;
            
        FOR j_cursos IN (SELECT *
                         FROM json_array_elements(j_id_cursos)) LOOP
            	
       -- raise EXCEPTION '%',  (j_cursos ->> 'id_curso');
        	
        		--RAISE exception 'id_ curso %',v_parametros.id_curso ; 
          		--RAISE EXCEPTION '%',v_parametros.id_curso;
                
       		v_id =(j_cursos ->> 'id_curso'):: INTEGER;
			
            --raise EXCEPTION '%', v_id;
            
   			FOR item IN(select
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
                        FUNCIO.codigo,
                        cur.nombre_curso,
                        cur.fecha_inicio,
                        FUNCIO.email_empresa,
                        (select usu11.id_usuario
                        from sigefo.tcurso_funcionario cff  
                        join sigefo.tcurso scuu on scuu.id_curso=cff.id_curso
                        join orga.tfuncionario ff on ff.id_funcionario=cff.id_funcionario
                        join segu.vpersona pp on pp.id_persona=ff.id_persona 
                        join segu.tusuario usu11 on usu11.id_persona = pp.id_persona where ff.id_funcionario=cufu.id_funcionario limit 1)::integer as id_usuario
                        
						from sigefo.tcurso_funcionario cufu
						inner join segu.tusuario usu1 on usu1.id_usuario = cufu.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cufu.id_usuario_mod
                        join orga.tfuncionario FUNCIO on FUNCIO.id_funcionario=cufu.id_funcionario
                        join SEGU.vpersona PERSON ON PERSON.id_persona=FUNCIO.id_persona
                        left join sigefo.tcurso cur on cur.id_curso= cufu.id_curso
                        where cufu.id_curso = v_id 
           		 )Loop
 
                 /*	
                  insert into param.talarma(
                                      acceso_directo,
                                      id_funcionario,
                                      fecha,
                                      estado_reg,
                                      descripcion,
                                      id_usuario_reg,
                                      fecha_reg,
                                      id_usuario_mod,
                                      fecha_mod,
                                      tipo,
                                      obs,
                                      clase,
                                      titulo,
                                      parametros,
                                      id_usuario,
                                      titulo_correo,
                                      correos,
                                      documentos,
                                      id_proceso_wf,
                                      id_estado_wf,
                                      id_plantilla_correo,
                                      estado_envio
                                      ) values(
                                      '../../../sis_formacion/vista/preguntas/Generador.php',--acceso_directo
                                      --item.id_funcionario::INTEGER,--par_id_funcionario 591 juan
                                      591,
                                      now(),--par_fecha
                                      'activo',
                                      '<font color="99CC00" size="5"><font size="4"> Evaluacion de curso - ENDESIS</font> </font><br><br><b></b>El motivo de la presente es solicitar evalúes el curso  de :<b>'||item.nombre_curso||'</b><br>realizado el '||item.fecha_inicio||' El cuestionario de evaluación se encuentra en el ENDESIS <br>en el siguiente enlace<br> <a href="http://172.18.79.204/etr/sis_seguridad/vista/_adm/index.php#main-tabs:CUR">enlace</a><br> Agradezco de antemano la colaboración. <br>Saludos',--par_descripcion
                                      1,--par_id_usuario admin
                                      now(),
                                      null,
                                      null,
                                      'notificacion',--par_tipo
                                      ''::varchar, --par_obs
                                      '',--par_clase
                                      'correo evaluacion de curso - ENDESIS',--par_titulo
                                      '',--par_parametros
                                      --item.id_usuario::INTEGER,--par_id_usuario_alarma 407 juan
                                      407,
                                     'correo evaluacion de curso - ENDESIS',--par_titulo correo
                                     'eddy.gutierrez@endetransmision.bo',--par_correos
                                      '',--par_documentos
                                      NULL,--p_id_proceso_wf
                                      NULL,--p_id_estado_wf
                                      NULL,--p_id_plantilla_correo
                                      'si'::character varying --v_estado_envio
                                    );   
                                    v_fecha=now();*/
                                    
                                    
                                    
                                IF((SELECT 	count(res.id_curso_funcionario_eval)		
                                        FROM  	sigefo.tcurso_funcionario_eval res
                                        WHERE res.id_curso =v_id and res.id_funcionario = item.id_funcionario) = 0 )THEN
                                    		
                                        	IF item.fecha_inicio is null  THEN
                                            	v_fecha_cadena = ' ';
                                            	v_fecha = now();
                                            else 
                                            	
                                            	v_fecha_cadena = 'realizado el '||item.fecha_inicio||'.';
                                            END IF;
                                            
                                             --raise exception 'item %',item.fecha_inicio;
                                            insert into param.talarma(
                                              acceso_directo,
                                              id_funcionario,
                                              fecha,
                                              estado_reg,
                                              descripcion,
                                              id_usuario_reg,
                                              fecha_reg,
                                              id_usuario_mod,
                                              fecha_mod,
                                              tipo,
                                              obs,
                                              clase,
                                              titulo,
                                              parametros,
                                              id_usuario,
                                              titulo_correo,
                                              correos,
                                              documentos,
                                              id_proceso_wf,
                                              id_estado_wf,
                                              id_plantilla_correo,
                                              estado_envio, --posible
                                              sw_correo,                                    
                                              pendiente
                                              ) values(
                                              '../../../sis_formacion/vista/preguntas/Generador.php', --acceso_directo
                                              item.id_funcionario::INTEGER,  --par_id_funcionario 591 juan
                                              now(), --par_fecha
                                              'activo',
                                              '<font color="000000" size="5"><font size="4"> </font> </font><br><br><b></b>El motivo de la presente es solicitar evalúes el curso  de : <b>'||item.nombre_curso||'</b><br> '||v_fecha_cadena||'El cuestionario de evaluación se encuentra en el ENDESIS <br>en el siguiente enlace<br> <a href="http://172.18.79.204/etr/sis_seguridad/vista/_adm/index.php#main-tabs:CUE">Evaluar curso</a><br> Agradezco de antemano la colaboración.<br>  Saludos<br> ',--par_descripcion
                                              1, --par_id_usuario admin
                                              now(),
                                              null,
                                              null,
                                              'notificacion',--par_tipo
                                              ''::varchar, --par_obs
                                              'Generador',--par_clase
                                              'Evaluacion de curso - ENDESIS',--par_titulo
                                              '',--par_parametros
                                              item.id_usuario::INTEGER,--par_id_usuario_alarma 407 juan
                                             'Evaluacion de curso - ENDESIS',--par_titulo correo
                                              '',--par_correos
                                              '',--par_documentos
                                              NULL,--p_id_proceso_wf
                                              NULL,--p_id_estado_wf
                                              NULL,--p_id_plantilla_correo
                                              'exito'::character varying, --v_estado_envio
                                              0,
                                              'no'
                                            ); 
                              ELSE
                              		RAISE NOTICE 'cuestionario respondido';
                                    RAISE INFO 'information message %', now() ;
                                    --RAISE exception 'cuestionario respondido';
                                     RAISE DEBUG 'debug message %', now();
 									 RAISE WARNING 'warning message %', now();
                              END IF;  

             	END LOOP;
    		END LOOP;
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
                        FUNCIO.codigo,
                        (select usu11.id_usuario
                        from sigefo.tcurso_funcionario cff  
                        join sigefo.tcurso scuu on scuu.id_curso=cff.id_curso
                        join orga.tfuncionario ff on ff.id_funcionario=cff.id_funcionario
                        join segu.vpersona pp on pp.id_persona=ff.id_persona 
                        join segu.tusuario usu11 on usu11.id_persona = pp.id_persona where ff.id_funcionario=cufu.id_funcionario limit 1)::integer as id_usuario
                        
						from sigefo.tcurso_funcionario cufu
						inner join segu.tusuario usu1 on usu1.id_usuario = cufu.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cufu.id_usuario_mod
                        join orga.tfuncionario FUNCIO on FUNCIO.id_funcionario=cufu.id_funcionario
                        join SEGU.vpersona PERSON ON PERSON.id_persona=FUNCIO.id_persona
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
           	raise NOTICE 'Expect counter starts with 0';
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

ALTER FUNCTION sigefo.ft_enviocorreo_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;