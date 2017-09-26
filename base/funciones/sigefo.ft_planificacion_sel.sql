CREATE OR REPLACE FUNCTION sigefo.ft_planificacion_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_planificacion_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigefo.tplanificacion'
 AUTOR: 		 (admin)
 FECHA:	        26-04-2017 20:37:24
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

  v_consulta       VARCHAR;
  v_parametros     RECORD;
  v_nombre_funcion TEXT;
  v_resp           VARCHAR;

BEGIN

  v_nombre_funcion = 'sigefo.ft_planificacion_sel';
  v_parametros = pxp.f_get_record(p_tabla);

  /*********************************
   #TRANSACCION:  'SIGEFO_SIGEFOP_SEL'
   #DESCRIPCION:	Consulta de datos
   #AUTOR:		admin
   #FECHA:		26-04-2017 20:37:24
  ***********************************/

  IF (p_transaccion = 'SIGEFO_SIGEFOP_SEL')
  THEN

    BEGIN
      --Sentencia de la consulta
      v_consulta:='select
						sigefop.id_planificacion,
						sigefop.id_gestion,
						sigefop.estado_reg,
						sigefop.cantidad_personas,
						sigefop.contenido_basico,
						sigefop.nombre_planificacion,
						sigefop.necesidad,
						sigefop.horas_previstas,
						sigefop.fecha_reg,
						sigefop.usuario_ai,
						sigefop.id_usuario_reg,
						sigefop.id_usuario_ai,
						sigefop.id_usuario_mod,
						sigefop.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						tg.gestion,
						(SELECT
  array_to_string( array_agg(tg.nombre), ''<br>'' )
FROM orga.tcargo tg join sigefo.tplanificacion_cargo pc ON pc.id_cargo=tg.id_cargo
where pc.id_planificacion=sigefop.id_planificacion)::varchar as desc_cargos,
						(SELECT
  array_to_string( array_agg(tg.id_cargo), '','' )
FROM orga.tcargo tg join sigefo.tplanificacion_cargo pc ON pc.id_cargo=tg.id_cargo
where pc.id_planificacion=sigefop.id_planificacion)::varchar as id_cargos,
									(select      array_to_string( array_agg(c.codigo), '','' )
from sigefo.tplanificacion_criterio pc join param.tcatalogo c on c.codigo = pc.cod_criterio
where pc.id_planificacion=sigefop.id_planificacion)::varchar as cod_criterio,
									(select      array_to_string( array_agg(c.descripcion), ''<br>'' )
from sigefo.tplanificacion_criterio pc join param.tcatalogo c on c.codigo = pc.cod_criterio
where pc.id_planificacion=sigefop.id_planificacion)::varchar as desc_criterio,
								(select      array_to_string( array_agg(co.competencia), ''<br>'' )
from sigefo.tplanificacion_competencia pco join sigefo.tcompetencia co on pco.id_competencia = co.id_competencia
where pco.id_planificacion=sigefop.id_planificacion)::varchar as desc_competencia,
									(select      array_to_string( array_agg(co.id_competencia), '','' )
from sigefo.tplanificacion_competencia pco join sigefo.tcompetencia co on pco.id_competencia = co.id_competencia
where pco.id_planificacion=sigefop.id_planificacion)::varchar as id_competencias,
									(select  array_to_string( array_agg(prov.desc_proveedor), ''<br>'' )
from sigefo.tplanificacion_proveedor pp join param.vproveedor prov ON pp.id_proveedor=prov.id_proveedor
where pp.id_planificacion=sigefop.id_planificacion)::varchar as desc_proveedores,
									(select  array_to_string( array_agg(pp.id_proveedor), '','' )
from sigefo.tplanificacion_proveedor pp
where pp.id_planificacion=sigefop.id_planificacion)::varchar as id_proveedores,
(select  array_to_string( array_agg(puo.id_uo), '','' )
 from sigefo.tplanificacion_uo puo
 where puo.id_planificacion=sigefop.id_planificacion)::varchar as id_uo,
(select  array_to_string( array_agg(uo.nombre_unidad), ''<br>'' )
 from sigefo.tplanificacion_uo puo join orga.tuo uo on puo.id_uo=uo.id_uo
 where puo.id_planificacion=sigefop.id_planificacion)::varchar as desc_uo
						from sigefo.tplanificacion sigefop
						inner join segu.tusuario usu1 on usu1.id_usuario = sigefop.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sigefop.id_usuario_mod
						inner join param.tgestion tg on sigefop.id_gestion=tg.id_gestion
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
     #TRANSACCION:  'SIGEFO_SIGEFOP_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		admin
     #FECHA:		26-04-2017 20:37:24
    ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_SIGEFOP_CONT')
    THEN

      BEGIN
        --Sentencia de la consulta de conteo de registros
        v_consulta:='select count(id_planificacion)
					    from sigefo.tplanificacion sigefop
					    inner join segu.tusuario usu1 on usu1.id_usuario = sigefop.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sigefop.id_usuario_mod
					    where ';

        --Definicion de la respuesta
        v_consulta:=v_consulta || v_parametros.filtro;

        --Devuelve la respuesta
        RETURN v_consulta;

      END;
      /*********************************
     #TRANSACCION:  'SIGEFO_SIGEFOCGU_SEL'
     #DESCRIPCION:	Mostrar los registro de los cargos
     #AUTOR:		yac
     #FECHA:		10-05-2017 20:37:24
    ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_SIGEFOCGU_SEL')
    THEN

      BEGIN
        --Sentencia de la consulta de conteo de registros
        v_consulta:='select
                    uo.id_uo,
                    uo.nombre_unidad
                    from orga.tuo uo
        where uo.gerencia=''si'' and ';

        --Definicion de la respuesta
        v_consulta:=v_consulta || v_parametros.filtro;
        v_consulta:=
        v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion || ' limit ' ||
        v_parametros.cantidad || ' offset ' || v_parametros.puntero;


        --v_consulta:=v_consulta || v_parametros.filtro || ' order by uo.nombre_unidad';
        --RAISE NOTICE '%', v_consulta;
       -- RAISE EXCEPTION 'yac erro ';

        --Devuelve la respuesta
        RETURN v_consulta;

      END;

      /*********************************
     #TRANSACCION:  'SIGEFO_SIGEFOCGU_CONT'
     #DESCRIPCION:	Conteo de registros del SIGEFO_SIGEFOCGU_SEL
     #AUTOR:		YAC
     #FECHA:		10-05-2017 20:37:24
    ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_SIGEFOCGU_CONT')
    THEN

      BEGIN
        --Sentencia de la consulta de conteo de registros
        v_consulta:='select
                    count(uo.id_uo)
                    from orga.tuo uo
        where uo.gerencia=''si'' and ';

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