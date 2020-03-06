--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_competencia_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_competencia_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigefo.tcompetencia'
 AUTOR: 		 (admin)
 FECHA:	        04-05-2017 19:30:13
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 ISSUE            FECHA:		      AUTOR                 DESCRIPCION
 #7               05/03/2020          JJA                   agregar gestión en competencias

***************************************************************************/

DECLARE

  v_consulta       VARCHAR;
  v_parametros     RECORD;
  v_nombre_funcion TEXT;
  v_resp           VARCHAR;

  v_ids_cargo      VARCHAR;

BEGIN

  v_nombre_funcion = 'sigefo.ft_competencia_sel';
  v_parametros = pxp.f_get_record(p_tabla);

  /*********************************
   #TRANSACCION:  'SIGEFO_COMCOMBO_SEL'
   #DESCRIPCION:	Consulta de datos
   #AUTOR:		JUAN
   #FECHA:		04-05-2017 19:30:13
  ***********************************/

  IF (p_transaccion = 'SIGEFO_COMCOMBO_SEL')
  THEN

    BEGIN
      --Sentencia de la consulta


           v_consulta:='SELECT  cn.id_competencia_nivel as id_competencia,c.competencia,c.tipo,(c.competencia||'' -> ''||cn.nivel)::VARCHAR as desc_competencia,c.id_competencia::integer as cod_competencia
                        from sigefo.tcompetencia c
                        join sigefo.tcompetencia_nivel cn on cn.id_competencia=c.id_competencia
				        where  ';

      --Definicion de la respuesta
      v_consulta:=v_consulta || v_parametros.filtro;
      v_consulta:=
      v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion || ' limit ' ||
      v_parametros.cantidad || ' offset ' || v_parametros.puntero;

      --Devuelve la respuesta
      RETURN v_consulta;

    END;

    /*********************************
  #TRANSACCION:  'SIGEFO_CCARGO_SEL'
  #DESCRIPCION:	se realizo esta copia de consulta de cargos para obtener el id no encryptado en el sistema de formacion
  #AUTOR:		JUAN
  #FECHA:		15-05-2017 19:16:06
 ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_CCARGO_SEL')
    THEN

      BEGIN
        --Sentencia de la consulta
        v_consulta:='SELECT c.id_cargo, c.id_cargo::integer as cod_cargo, c.nombre::varchar as nombre_cargo, (COALESCE(p.ap_paterno, '''') || '' '' || COALESCE(p.ap_materno, '''') || '', '' || COALESCE(p.nombre, ''''))::varchar as funcionario,

        (CASE WHEN  cc.id_competencia ISNULL THEN 0::INTEGER ELSE  cc.id_competencia END)::integer as id_competencia
FROM orga.tcargo c
JOIN orga.tuo tu on tu.id_uo=c.id_uo
JOIN orga.tuo_funcionario tf ON tf.id_cargo=c.id_cargo AND tf.fecha_asignacion<=CURRENT_DATE AND (tf.fecha_finalizacion IS NULL OR CURRENT_DATE<=tf.fecha_finalizacion)
JOIN orga.tfuncionario f on f.id_funcionario = tf.id_funcionario
JOIN segu.vpersona p on p.id_persona=f.id_persona
LEFT JOIN sigefo.tcargo_competencia cc on cc.id_cargo=c.id_cargo
WHERE tu.estado_reg=''activo'' and  c.fecha_ini<=CURRENT_DATE AND (c.fecha_fin IS NULL OR CURRENT_DATE<=c.fecha_fin) and   ';

        --Definicion de la respuesta
        v_consulta:=v_consulta || v_parametros.filtro;
        v_consulta:=
        v_consulta || ' ORDER BY c.nombre ' || v_parametros.dir_ordenacion || ' limit ' ||
        v_parametros.cantidad || ' offset ' || v_parametros.puntero;

        --Devuelve la respuesta
        RETURN v_consulta;

      END;

      /*********************************
    #TRANSACCION:  'SIGEFO_CCOMP_SEL'
    #DESCRIPCION:	se realizo esta copia de consulta sel de competencia para relacionar entre cargo y competencia, por motivos que la tabla cargo_competencia no tiene un identificador único
    #AUTOR:		JUAN
    #FECHA:		16-05-2017 19:16:06
   ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_CCOMP_SEL')
    THEN

      BEGIN
        --Sentencia de la consulta
        v_consulta:='select
						sigefoco.id_competencia,
						tc.descripcion as tipo,
						sigefoco.estado_reg,
						sigefoco.competencia,
						sigefoco.id_usuario_ai,
						sigefoco.id_usuario_reg,
						sigefoco.fecha_reg,
						sigefoco.usuario_ai,
						sigefoco.id_usuario_mod,
						sigefoco.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        sigefoco.id_competencia as cod_competencia,
                        cc.id_cargo
						from sigefo.tcompetencia sigefoco
						inner join segu.tusuario usu1 on usu1.id_usuario = sigefoco.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sigefoco.id_usuario_mod
									left join param.tcatalogo tc on tc.codigo = sigefoco.tipo
                                    join sigefo.tcargo_competencia cc on cc.id_competencia=sigefoco.id_competencia
				        where  ';

        --Definicion de la respuesta
        v_consulta:=v_consulta || v_parametros.filtro;
        v_consulta:=
        v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion || ' limit ' ||
        v_parametros.cantidad || ' offset ' || v_parametros.puntero;

        --Devuelve la respuesta
        RETURN v_consulta;

      END;

      /*********************************
    #TRANSACCION:  'SIGEFO_CCOMP_CONT'
    #DESCRIPCION:	Contador de la transaccion SIGEFO_CCOMP_SEL
    #AUTOR:		JUAN
    #FECHA:		16-05-2017 19:16:06
   ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_CCOMP_CONT')
    THEN

      BEGIN
        --Sentencia de la consulta de conteo de registros
        v_consulta:='select count(sigefoco.id_competencia)
					    from sigefo.tcompetencia sigefoco
					    inner join segu.tusuario usu1 on usu1.id_usuario = sigefoco.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sigefoco.id_usuario_mod
									left join param.tcatalogo tc on tc.codigo = sigefoco.tipo
                                    join sigefo.tcargo_competencia cc on cc.id_competencia=sigefoco.id_competencia
					    where ';

        --Definicion de la respuesta
        v_consulta:=v_consulta || v_parametros.filtro;

        --Devuelve la respuesta
        -- RAISE NOTICE '%',v_consulta;
        RETURN v_consulta;

      END;

      /*********************************
    #TRANSACCION:  'SIGEFO_CCARGO_CONT'
    #DESCRIPCION:	se realizo esta copia de consulta de cargos para obtener el id no encryptado en el sistema de formacion
    #AUTOR:		JUAN
    #FECHA:		15-05-2017 19:16:06
   ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_CCARGO_CONT')
    THEN

      BEGIN
        --Sentencia de la consulta de conteo de registros
        v_consulta:='SELECT count(c.id_cargo) FROM orga.tcargo c
JOIN orga.tuo tu on tu.id_uo=c.id_uo
JOIN orga.tuo_funcionario tf ON tf.id_cargo=c.id_cargo AND tf.fecha_asignacion<=CURRENT_DATE AND (tf.fecha_finalizacion IS NULL OR CURRENT_DATE<=tf.fecha_finalizacion)
JOIN orga.tfuncionario f on f.id_funcionario = tf.id_funcionario
JOIN segu.vpersona p on p.id_persona=f.id_persona
LEFT JOIN sigefo.tcargo_competencia cc on cc.id_cargo=c.id_cargo
WHERE tu.estado_reg=''activo'' and c.fecha_ini<=CURRENT_DATE AND (c.fecha_fin IS NULL OR CURRENT_DATE<=c.fecha_fin) and';

        --Definicion de la respuesta
        v_consulta:=v_consulta || v_parametros.filtro;


        --Devuelve la respuesta
        RETURN v_consulta;

      END;

      /*********************************
       #TRANSACCION:  'SIGEFO_COMCOMBO_CONT'
       #DESCRIPCION:	Conteo de registros
       #AUTOR:		admin
       #FECHA:		04-05-2017 19:30:13
      ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_COMCOMBO_CONT')
    THEN

      BEGIN
        --Sentencia de la consulta de conteo de registros
        v_consulta:='SELECT count(c.id_competencia) FROM sigefo.tcompetencia c
                     join sigefo.tcompetencia_nivel cn on cn.id_competencia=c.id_competencia
					    where ';

        --Definicion de la respuesta
        v_consulta:=v_consulta || v_parametros.filtro;

        --Devuelve la respuesta
        RETURN v_consulta;

      END;
  /*********************************
   #TRANSACCION:  'SIGEFO_SIGEFOCO_SEL'
   #DESCRIPCION:	Consulta de datos
   #AUTOR:		admin
   #FECHA:		04-05-2017 19:30:13
  ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_SIGEFOCO_SEL')
  THEN

    BEGIN
      --Sentencia de la consulta
      v_consulta:='select DISTINCT
						sigefoco.id_competencia,
						--tc.descripcion as tipo,
                        sigefoco.tipo,
						sigefoco.estado_reg,
						sigefoco.competencia,
						sigefoco.id_usuario_ai,
						sigefoco.id_usuario_reg,
						sigefoco.fecha_reg,
						sigefoco.usuario_ai,
						sigefoco.id_usuario_mod,
						sigefoco.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						sigefoco.id_competencia as cod_competencia,
                        sigefoco.descripcion,
                        gc.id_gestion::integer --#7
						from sigefo.tcompetencia sigefoco
                        join sigefo.tgestion_competencia gc on gc.id_competencia=sigefoco.id_competencia --#7
                        join param.tgestion g on g.id_gestion=gc.id_gestion --#7
						inner join segu.tusuario usu1 on usu1.id_usuario = sigefoco.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sigefoco.id_usuario_mod
						left join param.tcatalogo tc on tc.codigo = sigefoco.tipo
						left join sigefo.tcargo_competencia cp on cp.id_competencia=sigefoco.id_competencia
				        where  ';

      --Definicion de la respuesta
      v_consulta:=v_consulta || v_parametros.filtro;
      v_consulta:=
      v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion || ' limit ' ||
      v_parametros.cantidad || ' offset ' || v_parametros.puntero;

      --Devuelve la respuesta
      RETURN v_consulta;

    END;

      /*********************************
       #TRANSACCION:  'SIGEFO_SIGEFOCO_CONT'
       #DESCRIPCION:	Conteo de registros
       #AUTOR:		admin
       #FECHA:		04-05-2017 19:30:13
      ***********************************/

      ELSIF (p_transaccion = 'SIGEFO_SIGEFOCO_CONT')
        THEN

          BEGIN
            --Sentencia de la consulta de conteo de registros
            v_consulta:='select count(DISTINCT sigefoco.id_competencia)
                            from sigefo.tcompetencia sigefoco
                            join sigefo.tgestion_competencia gc on gc.id_competencia=sigefoco.id_competencia --#7
                            join param.tgestion g on g.id_gestion=gc.id_gestion --#7
                            inner join segu.tusuario usu1 on usu1.id_usuario = sigefoco.id_usuario_reg
                            left join segu.tusuario usu2 on usu2.id_usuario = sigefoco.id_usuario_mod
                            left join param.tcatalogo tc on tc.codigo = sigefoco.tipo
                            left join sigefo.tcargo_competencia cp on cp.id_competencia=sigefoco.id_competencia
                            where ';

            --Definicion de la respuesta
            v_consulta:=v_consulta || v_parametros.filtro;

            --Devuelve la respuesta
            RETURN v_consulta;

          END;

  ELSE

    RAISE EXCEPTION 'Transaccion inexistente';

  END IF;

  EXCEPTION

  WHEN OTHERS
    THEN
      v_resp = '';
      v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', SQLERRM);
      v_resp = pxp.f_agrega_clave(v_resp, 'codigo_error', SQLSTATE);
      v_resp = pxp.f_agrega_clave(v_resp, 'procedimientos', v_nombre_funcion);
      RAISE EXCEPTION '%', v_resp;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;