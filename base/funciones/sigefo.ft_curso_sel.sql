--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_curso_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_curso_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigefo.tcurso'
 AUTOR: 		 (admin)
 FECHA:	        22-01-2017 15:35:03
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 ISSUE            FECHA:		      AUTOR                 DESCRIPCION
 #3               13/02/2020          JJA                   Agregado de filtro en curso por funcinario
***************************************************************************/

DECLARE

  v_var            VARCHAR ;
  v_count          INTEGER;
  v_consulta       VARCHAR;
  v_consultaTemp   VARCHAR;
  v_consultaInsert VARCHAR;
  v_parametros      RECORD;
  v_nombre_funcion 	  TEXT;
  v_resp           VARCHAR;
  item              RECORD;
  item2             RECORD;
  item1             RECORD;
  v_aux            VARCHAR;
  aux            VARCHAR;
  v_aux1           VARCHAR;
  v_cont           INTEGER;
  v_anio           INTEGER;
  v_cont_avance    INTEGER;
  v_consulta1      VARCHAR;
  v_consulta2      VARCHAR;

  v_ids			varchar;
  v_total          NUMERIC;
  v_bandera_sigeco_admin VARCHAR;

BEGIN

  v_nombre_funcion = 'sigefo.ft_curso_sel';
  v_parametros = pxp.f_get_record(p_tabla);

  /*********************************
   #TRANSACCION:  'SIGEFO_SCU_SEL'
   #DESCRIPCION:	Consulta de datos
   #AUTOR:		JUAN
   #FECHA:		22-01-2017 15:35:03
  ***********************************/


  	IF (p_transaccion = 'SIGEFO_SCU_SEL')
		THEN
          BEGIN
              v_consulta:='WITH funcionario as (SELECT array_to_string( array_agg(PERSON.nombre_completo2) , ''<br>'' ) as funcionarios ,c.id_curso  -- #3
                          FROM sigefo.tcurso_funcionario cf
                          JOIN sigefo.tcurso c ON c.id_curso=cf.id_curso
                          JOIN orga.tfuncionario FUNCIO ON FUNCIO.id_funcionario=cf.id_funcionario
                          JOIN SEGU.vpersona PERSON ON PERSON.id_persona=FUNCIO.id_persona
                          group by c.id_curso)
                          SELECT
                          scu.id_curso,
                          scu.id_gestion,
                          scu.id_lugar,
                          scu.id_lugar_pais,
                          scu.id_proveedor,
                          scu.origen,
                          scu.fecha_inicio,
                          scu.objetivo,
                          scu.estado_reg,
                          scu.cod_tipo,
                          scu.cod_prioridad,
                          scu.horas,
                          scu.nombre_curso,
                          scu.cod_clasificacion,
                          scu.expositor,
                          scu.contenido,
                          scu.fecha_fin,
                          scu.fecha_reg,
                          scu.usuario_ai,
                          scu.id_usuario_reg,
                          scu.id_usuario_ai,
                          scu.id_usuario_mod,
                          scu.fecha_mod,
                          scu.evaluacion,
                          scu.certificacion,
                          g.gestion AS gestion,

                          (SELECT lp.nombre
                          FROM param.tlugar lp
                          WHERE lp.id_lugar=scu.id_lugar_pais ) :: VARCHAR  AS nombre_pais,

                          (SELECT lp.nombre
                          FROM param.tlugar lp
                          WHERE lp.id_lugar=scu.id_lugar ) :: VARCHAR  AS nombre,

                          (SELECT p.desc_proveedor
                          FROM param.vproveedor p
                          WHERE p.id_proveedor=scu.id_proveedor ) :: VARCHAR  AS desc_proveedor,


                          (SELECT usu1.cuenta
                          FROM segu.tusuario usu1
                          WHERE usu1.id_usuario =scu.id_usuario_reg )  :: VARCHAR  AS usr_reg,

                          (SELECT usu2.cuenta
                          FROM segu.tusuario usu2
                          WHERE usu2.id_usuario =scu.id_usuario_mod )  :: VARCHAR  AS usr_mod,


                          /*(SELECT array_to_string( array_agg( cc.id_competencia), '','' )
                          FROM sigefo.tcurso_competencia cc
                          JOIN sigefo.tcurso c ON c.id_curso=cc.id_curso
                          WHERE cc.id_curso=scu.id_curso)::VARCHAR AS id_competencias,

                          (SELECT array_to_string( array_agg( co.competencia), ''<br>'' )
                          FROM sigefo.tcurso_competencia cc
                          JOIN sigefo.tcurso c ON c.id_curso=cc.id_curso
                          JOIN sigefo.tcompetencia co ON co.id_competencia=cc.id_competencia
                          WHERE cc.id_curso=scu.id_curso)::VARCHAR AS desc_competencia,*/

                          (SELECT array_to_string( array_agg( cn.id_competencia_nivel), '','' )
                          FROM sigefo.tcurso_competencia cc
                          JOIN sigefo.tcurso c ON c.id_curso=cc.id_curso
                          JOIN sigefo.tcompetencia_nivel cn on cn.id_competencia_nivel=cc.id_competencia_nivel
                          WHERE cc.id_curso=scu.id_curso)::VARCHAR AS id_competencias,

                          (SELECT array_to_string( array_agg(  (co.competencia||'' -> ''||co.tipo||'' -> ''||cn.nivel)::VARCHAR  ), ''<br>'' )
                          FROM sigefo.tcurso_competencia cc
                          JOIN sigefo.tcurso c ON c.id_curso=cc.id_curso
                          JOIN sigefo.tcompetencia co ON co.id_competencia=cc.id_competencia
                          JOIN sigefo.tcompetencia_nivel cn on cn.id_competencia_nivel=cc.id_competencia_nivel
                          WHERE cc.id_curso=scu.id_curso)::VARCHAR AS desc_competencia,


                          scu.id_planificacion::INTEGER,

                          (SELECT  pl.nombre_planificacion
                          FROM sigefo.tplanificacion pl
                          WHERE pl.id_planificacion=scu.id_planificacion)::VARCHAR AS planificacion,



                          (SELECT array_to_string( array_agg( cf.id_funcionario), '','' )
                          FROM sigefo.tcurso_funcionario cf
                          JOIN sigefo.tcurso c ON c.id_curso=cf.id_curso
                          WHERE cf.id_curso=scu.id_curso)::VARCHAR AS id_funcionarios,

                          fun.funcionarios::VARCHAR as funcionarios, --#3

                          scu.id_gerencia::INTEGER AS id_uo,
                          (SELECT tu.nombre_unidad FROM sigefo.tcurso p  join orga.tuo tu ON p.id_gerencia=tu.id_uo where scu.id_gerencia=tu.id_uo and p.id_curso=scu.id_curso	)::VARCHAR as desc_uo,

                          scu.id_unidad_organizacional::INTEGER,
                          (SELECT tu.nombre_cargo from sigefo.tcurso  pl
                          join orga.tuo tu on tu.id_uo=pl.id_unidad_organizacional
                          where pl.id_curso=scu.id_curso)::varchar as unidad_organizacional,
                          scu.peso::NUMERIC,
                          (SELECT count(cfuncio.id_funcionario) from sigefo.tcurso_funcionario cfuncio where cfuncio.id_curso=scu.id_curso)::INTEGER as cantidad_personas,
                          scu.comite_etica

                          FROM sigefo.tcurso scu
                          JOIN param.tgestion g ON g.id_gestion=scu.id_gestion
                          join funcionario fun on fun.id_curso=scu.id_curso --#3
                          WHERE';

                --raise exception 'error provocado %' ,v_consulta;
                v_consulta:=v_consulta || v_parametros.filtro;
                v_consulta:=
                v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion || ' limit ' ||
                v_parametros.cantidad || ' offset ' || v_parametros.puntero;
                raise notice 'notic %',v_consulta;

              RETURN v_consulta;
          END;
    /*********************************
     #TRANSACCION:  'SIGEFO_SCU_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		admin
     #FECHA:		22-01-2017 15:35:03
    ***********************************/

	ELSIF (p_transaccion = 'SIGEFO_SCU_CONT')
    	THEN
      		BEGIN
        		v_consulta:='WITH funcionario as (SELECT array_to_string( array_agg(PERSON.nombre_completo2) , ''<br>'' ) as funcionarios ,c.id_curso
                          FROM sigefo.tcurso_funcionario cf
                          JOIN sigefo.tcurso c ON c.id_curso=cf.id_curso
                          JOIN orga.tfuncionario FUNCIO ON FUNCIO.id_funcionario=cf.id_funcionario
                          JOIN SEGU.vpersona PERSON ON PERSON.id_persona=FUNCIO.id_persona
                          group by c.id_curso)
                        select count(scu.id_curso)
					    from sigefo.tcurso scu
					    inner join segu.tusuario usu1 on usu1.id_usuario = scu.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = scu.id_usuario_mod
                        JOIN param.tgestion g ON g.id_gestion=scu.id_gestion --#3
                        join funcionario fun on fun.id_curso=scu.id_curso --#3
					    where ';
                v_consulta:=v_consulta || v_parametros.filtro;
                RETURN v_consulta;
            END;
/*********************************
   #TRANSACCION:  'SIGEFO_CURCUEST_SEL'
   #DESCRIPCION:	Consulta de datos
   #AUTOR:		JUAN
   #FECHA:		22-01-2017 15:35:03
  ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_CURCUEST_SEL')
		THEN
          BEGIN
          --RAISE EXCEPTION 'Error provocado por juan %',v_parametros.id_usuario;

            IF((SELECT count(p.codigo) from segu.tusuario u
              join segu.tusuario_rol ur on ur.id_usuario=u.id_usuario and ur.estado_reg='activo'
              join segu.trol r on r.id_rol=ur.id_rol
              join segu.trol_procedimiento_gui rpg on rpg.id_rol=r.id_rol
              join segu.tprocedimiento_gui pg on pg.id_procedimiento_gui=rpg.id_procedimiento_gui
              join segu.tprocedimiento p on p.id_procedimiento=pg.id_procedimiento
              join segu.tgui g on g.id_gui= pg.id_gui
              where u.id_usuario=v_parametros.id_usuario::INTEGER and r.rol='SIGECO - Admin')>0 )THEN

                    v_bandera_sigeco_admin := ' 0 = 0 ';

              ELSE

                    v_bandera_sigeco_admin := '( usu1.id_usuario = '||v_parametros.id_usuario::INTEGER||' or cf.id_usuario_reg = '||v_parametros.id_usuario::INTEGER||' )';

             END IF;
              v_consulta:='SELECT
                          scu.id_curso,
                          scu.id_gestion,
                          scu.id_lugar,
                          scu.id_lugar_pais,
                          scu.id_proveedor,
                          scu.origen,
                          scu.fecha_inicio,
                          scu.objetivo,
                          scu.estado_reg,
                          scu.cod_tipo,
                          scu.cod_prioridad,
                          scu.horas,
                          scu.nombre_curso,
                          scu.cod_clasificacion,
                          scu.expositor,
                          scu.contenido,
                          scu.fecha_fin,
                          scu.fecha_reg,
                          scu.usuario_ai,
                          scu.id_usuario_reg,
                          scu.id_usuario_ai,
                          scu.id_usuario_mod,
                          scu.fecha_mod,
                          scu.evaluacion,
                          scu.certificacion,
                          g.gestion AS gestion,

                          (SELECT lp.nombre
                          FROM param.tlugar lp
                          WHERE lp.id_lugar=scu.id_lugar_pais ) :: VARCHAR  AS nombre_pais,

                          (SELECT lp.nombre
                          FROM param.tlugar lp
                          WHERE lp.id_lugar=scu.id_lugar ) :: VARCHAR  AS nombre,

                          (SELECT p.desc_proveedor
                          FROM param.vproveedor p
                          WHERE p.id_proveedor=scu.id_proveedor ) :: VARCHAR  AS desc_proveedor,


                          (SELECT usu1.cuenta
                          FROM segu.tusuario usu1
                          WHERE usu1.id_usuario =scu.id_usuario_reg )  :: VARCHAR  AS usr_reg,

                          (SELECT usu2.cuenta
                          FROM segu.tusuario usu2
                          WHERE usu2.id_usuario =scu.id_usuario_mod )  :: VARCHAR  AS usr_mod,


                          (SELECT array_to_string( array_agg( cc.id_competencia), '','' )
                          FROM sigefo.tcurso_competencia cc
                          JOIN sigefo.tcurso c ON c.id_curso=cc.id_curso
                          WHERE cc.id_curso=scu.id_curso)::VARCHAR AS id_competencias,

                          (SELECT array_to_string( array_agg( co.competencia), ''<br>'' )
                          FROM sigefo.tcurso_competencia cc
                          JOIN sigefo.tcurso c ON c.id_curso=cc.id_curso
                          JOIN sigefo.tcompetencia co ON co.id_competencia=cc.id_competencia
                          WHERE cc.id_curso=scu.id_curso)::VARCHAR AS desc_competencia,


                          scu.id_planificacion::INTEGER,

                          (SELECT  pl.nombre_planificacion
                          FROM sigefo.tplanificacion pl
                          WHERE pl.id_planificacion=scu.id_planificacion)::VARCHAR AS planificacion,



                          (SELECT array_to_string( array_agg( cf.id_funcionario), '','' )
                          FROM sigefo.tcurso_funcionario cf
                          JOIN sigefo.tcurso c ON c.id_curso=cf.id_curso
                          WHERE cf.id_curso=scu.id_curso)::VARCHAR AS id_funcionarios,

                          (SELECT array_to_string( array_agg(PERSON.nombre_completo2), ''<br>'' )
                          FROM sigefo.tcurso_funcionario cf
                          JOIN sigefo.tcurso c ON c.id_curso=cf.id_curso
                          JOIN orga.tfuncionario FUNCIO ON FUNCIO.id_funcionario=cf.id_funcionario
                          JOIN SEGU.vpersona PERSON ON PERSON.id_persona=FUNCIO.id_persona
                          WHERE cf.id_curso=scu.id_curso)::VARCHAR AS funcionarios,

                          scu.id_gerencia::INTEGER AS id_uo,
                          (SELECT tu.nombre_unidad FROM sigefo.tcurso p  join orga.tuo tu ON p.id_gerencia=tu.id_uo where scu.id_gerencia=tu.id_uo and p.id_curso=scu.id_curso	)::VARCHAR as desc_uo,

                          scu.id_unidad_organizacional::INTEGER,
                          (SELECT tu.nombre_cargo from sigefo.tcurso  pl
                          join orga.tuo tu on tu.id_uo=pl.id_unidad_organizacional
                          where pl.id_curso=scu.id_curso)::varchar as unidad_organizacional,
                          scu.peso::NUMERIC,
                          (SELECT count(cfuncio.id_funcionario) from sigefo.tcurso_funcionario cfuncio where cfuncio.id_curso=scu.id_curso)::INTEGER as cantidad_personas,
                          (SELECT p.nombre_completo2 from segu.tusuario usu11 join segu.vpersona p on p.id_persona=usu11.id_persona where usu11.id_usuario =usu1.id_usuario)::VARCHAR as funcionario_eval,
                          cf.id_funcionario,
                          (SELECT usu11.cuenta from segu.tusuario usu11 where usu11.id_usuario=usu1.id_usuario)::varchar AS usuario,
                          usu1.id_usuario::INTEGER as id_usuario,
                          (p.ap_paterno||'' ''||p.ap_materno||'', ''||p.nombre)::VARCHAR as funcionario,
                          cf.id_curso_funcionario
                          FROM sigefo.tcurso scu
                          JOIN param.tgestion g ON g.id_gestion=scu.id_gestion
                          JOIN sigefo.tcurso_funcionario cf on cf.id_curso=scu.id_curso

                          join orga.tfuncionario f on f.id_funcionario=cf.id_funcionario
                          join segu.vpersona p on p.id_persona=f.id_persona
                          join segu.tusuario usu1 on usu1.id_persona = p.id_persona  and usu1.estado_reg=''activo''

                          WHERE '||v_bandera_sigeco_admin||'
                          and ';

                --raise NOTICE 'raise juan %',v_consulta;
                --raise exception 'error provocado %' ,v_consulta;
                v_consulta:=v_consulta || v_parametros.filtro;
                v_consulta:=
                v_consulta || ' order by   scu.nombre_curso  ' || v_parametros.dir_ordenacion || ' limit ' ||
                v_parametros.cantidad || ' offset ' || v_parametros.puntero;
                --RAISE NOTICE 'error provocado %',v_consulta;
                --RAISE EXCEPTION 'error provocado %',v_consulta;
              RETURN v_consulta;
          END;

    /*********************************
     #TRANSACCION:  'SIGEFO_CURCUEST_CONT'
     #DESCRIPCION:	Conteo de registros
     #AUTOR:		admin
     #FECHA:		22-01-2017 15:35:03
    ***********************************/

	ELSIF (p_transaccion = 'SIGEFO_CURCUEST_CONT')
    	THEN
      		BEGIN

            IF((SELECT count(p.codigo) from segu.tusuario u
              join segu.tusuario_rol ur on ur.id_usuario=u.id_usuario and ur.estado_reg='activo'
              join segu.trol r on r.id_rol=ur.id_rol
              join segu.trol_procedimiento_gui rpg on rpg.id_rol=r.id_rol
              join segu.tprocedimiento_gui pg on pg.id_procedimiento_gui=rpg.id_procedimiento_gui
              join segu.tprocedimiento p on p.id_procedimiento=pg.id_procedimiento
              join segu.tgui g on g.id_gui= pg.id_gui
              where u.id_usuario=v_parametros.id_usuario::INTEGER and r.rol='SIGECO - Admin')>0 )THEN

                    v_bandera_sigeco_admin := ' 0 = 0 ';

              ELSE

                    v_bandera_sigeco_admin := '( usu1.id_usuario = '||v_parametros.id_usuario::INTEGER||' or cf.id_usuario_reg = '||v_parametros.id_usuario::INTEGER||' )';

             END IF;

        		v_consulta:='select count(scu.id_curso)
                          FROM sigefo.tcurso scu
                          JOIN param.tgestion g ON g.id_gestion=scu.id_gestion
                          JOIN sigefo.tcurso_funcionario cf on cf.id_curso=scu.id_curso

                          join orga.tfuncionario f on f.id_funcionario=cf.id_funcionario
                          join segu.vpersona p on p.id_persona=f.id_persona
                          join segu.tusuario usu1 on usu1.id_persona = p.id_persona  and usu1.estado_reg=''activo''

                          WHERE '||v_bandera_sigeco_admin||'
                          and ';

                v_consulta:=v_consulta || v_parametros.filtro;
                RETURN v_consulta;
            END;

    /*********************************
    #TRANSACCION:  'PM_LUG_SEL'
    #DESCRIPCION:	Consulta de datos
    #AUTOR:		rac
    #FECHA:		29-08-2011 09:19:28
    ***********************************/

    ELSEIF (p_transaccion = 'PM_PAISLUGAR_SEL')
    	THEN
			BEGIN
        		v_consulta:='select
                            lug.id_lugar,
                            lug.nombre,
                            lug.tipo
                          	FROM param.tlugar lugp LEFT JOIN param.tlugar lug ON lugp.id_lugar = lug.id_lugar_fk
							where';

                v_consulta:=v_consulta || v_parametros.filtro;
                v_consulta:=
                v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion || ' limit ' ||
                v_parametros.cantidad || ' offset ' || v_parametros.puntero;
        		RETURN v_consulta;
      		END;
/*    /*********************************
    #TRANSACCION:  'DAT_PLANIFICA_SEL'
    #DESCRIPCION:	Consulta de datos
    #AUTOR:		rac
    #FECHA:		29-08-2011 09:19:28
    ***********************************/

    ELSEIF (p_transaccion = 'DAT_PLANIFICA_SEL')
    	THEN
			BEGIN
        		v_consulta:='SELECT id_gerencia,id_unidad_organizacional FROM sigefo.tplanificacion where id_planificacion= '||v_parametros.id_planificacion;
                --RAISE EXCEPTION 'error provocado juan %',v_consulta;
                --v_consulta:=v_consulta || v_parametros.filtro;
                --v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion || ' limit ' ||
               -- v_parametros.cantidad || ' offset ' || v_parametros.puntero;
        		RETURN v_consulta;
      		END;

    /*********************************
    #TRANSACCION:  'DAT_PLANIFICA_CONT'
    #DESCRIPCION:	Conteo de registros
    #AUTOR:		rac
    #FECHA:		29-08-2011 09:19:28
    ***********************************/

    ELSIF (p_transaccion = 'DAT_PLANIFICA_CONT')
    	THEN
    		BEGIN
                v_consulta:='SELECT count(id_gerencia) FROM sigefo.tplanificacion where id_planificacion= '||v_parametros.id_planificacion;

    			--v_consulta:=v_consulta || v_parametros.filtro;
		    	RETURN v_consulta;
    		END;

     */
    /*********************************
    #TRANSACCION:  'PM_LUG_CONT'
    #DESCRIPCION:	Conteo de registros
    #AUTOR:		rac
    #FECHA:		29-08-2011 09:19:28
    ***********************************/

    ELSIF (p_transaccion = 'PM_PAISLUGAR_CONT')
    	THEN
    		BEGIN
    			v_consulta:='select count(lug.id_lugar)
                            FROM param.tlugar lugp LEFT JOIN param.tlugar lug ON lugp.id_lugar = lug.id_lugar_fk
    						where ';
    			v_consulta:=v_consulta || v_parametros.filtro;
		    	RETURN v_consulta;
    		END;

    /*********************************
    #TRANSACCION:  'SIGEFO_LCURSO_CONT'
    #DESCRIPCION:	Conteo de registros
    #AUTOR:		rac
    #FECHA:		29-08-2011 09:19:28
    ***********************************/

    ELSIF (p_transaccion = 'SIGEFO_LCURSO_CONT')
    	THEN
    		BEGIN
    			v_consulta:='select count(id_curso)
					    from sigefo.tcurso scu
					    inner join segu.tusuario usu1 on usu1.id_usuario = scu.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = scu.id_usuario_mod
					    where scu.id_gestion='||v_parametros.id_gestion;
		    	RETURN v_consulta;
    		END;

    /*********************************
    #TRANSACCION:  'SIGEFO_LCURSO_SEL'
    #DESCRIPCION:	LISTA DINAMICA
    #AUTOR:		JUAN
    #FECHA:		15-11-2017 09:19:28
    ***********************************/

    ELSEIF (p_transaccion = 'SIGEFO_LCURSO_SEL') THEN
    	BEGIN
            IF (v_parametros.id_gestion :: INTEGER >= 0) THEN

                --Creamos tabla temporal
				v_consulta1 :='';
                v_consulta1 := v_consulta1 || 'CREATE TEMP TABLE ttemporal( id_temporal SERIAL,
                                                                                id_curso INTEGER,
                                                                                nombre_curso VARCHAR,
                                                                                id_gestion INTEGER,
                                                                                cod_prioridad VARCHAR,
                                                                                horas INTEGER,
                                                                                peso NUMERIC
                                                                                ';
            	v_cont_avance:=0;
            	FOR item IN(SELECT t.mes FROM sigefo.tavance_real t
                            JOIN sigefo.tcurso c on c.id_curso=t.id_curso and t.id_curso=(SELECT cc.id_curso from sigefo.tcurso cc where cc.id_gestion=v_parametros.id_gestion limit 1)
                            where c.id_gestion=v_parametros.id_gestion
                            order by t.id_avance_real) LOOP
                  v_cont_avance:= v_cont_avance+1;
                  v_consulta1 :=v_consulta1||','||item.mes||' VARCHAR';
                  v_consulta1 :=v_consulta1||', id_lavance'||v_cont_avance||' INTEGER';
           		END LOOP;
           		v_consulta1 :=v_consulta1||', total varchar) ON COMMIT DROP';
                --RAISE EXCEPTION 'error provocado por juan %',v_consulta1;
           		EXECUTE(v_consulta1);
                ----------------------insertamos a la tabla temporal--------------------------
                v_consulta2 :='';
            	v_consulta2 := v_consulta2 || 'INSERT INTO ttemporal (id_curso,
                                                                          nombre_curso,
                                                                          id_gestion,
                                                                          cod_prioridad,
                                                                          horas,
                                                                          peso';
            	v_cont_avance:=0;
            	FOR item IN (SELECT t.mes FROM sigefo.tavance_real t
                             JOIN sigefo.tcurso c on c.id_curso=t.id_curso and t.id_curso=(SELECT cc.id_curso from sigefo.tcurso cc where cc.id_gestion=v_parametros.id_gestion limit 1)
                             where c.id_gestion=v_parametros.id_gestion order by t.id_avance_real) LOOP
                    v_cont_avance := v_cont_avance+1;
                    v_consulta2 :=v_consulta2||','||item.mes||',id_lavance'||v_cont_avance;
            	END LOOP;
		        v_consulta2 :=v_consulta2||', total) VALUES ';

                v_consulta1:='';
                FOR item IN (SELECT c.id_curso,
                                    c.nombre_curso :: VARCHAR,
                                    c.id_gestion ::INTEGER,
                                    c.cod_prioridad :: VARCHAR,
                                    (CASE WHEN (c.horas is null or c.horas::VARCHAR='')THEN 0 ELSE c.horas::NUMERIC END)::NUMERIC AS horas,
                                    (CASE WHEN (c.peso is null or c.peso::VARCHAR='')THEN 0 ELSE c.peso::NUMERIC END)::NUMERIC AS peso
                                    FROM sigefo.tcurso c  WHERE c.id_gestion=v_parametros.id_gestion)LOOP


                        v_consulta1 :='('||item.id_curso||',''' || item.nombre_curso||''','||item.id_gestion||','''||item.cod_prioridad||''','|| item.horas||','||item.peso;

                        v_total :=0::numeric;
                        FOR item1 IN (select ar.mes, ar.id_avance_real,ar.avance_real,ar.id_curso
                                     from sigefo.tavance_real ar where ar.id_curso = item.id_curso::INTEGER order by ar.id_avance_real)LOOP

                                 v_consulta1 := v_consulta1||','||item1.avance_real::NUMERIC;
                                 v_consulta1 :=v_consulta1||','||item1.id_avance_real::INTEGER;

                                 v_total :=v_total +item1.avance_real::NUMERIC;

                         END LOOP;

                         v_consulta1 := v_consulta1||','||v_total::VARCHAR||')';
                         --RAISE EXCEPTION 'Error provocado por juan  %',REPLACE(v_consulta2,'''', '&');
                        --EXECUTE(v_consulta2);
                        execute(v_consulta2||v_consulta1);
                END LOOP;
                ---------------------------------------------------------------------------
                v_consulta:='SELECT * FROM ttemporal';
            END IF;
        RETURN v_consulta;
    END;
    /*********************************
  #TRANSACCION:  'SIGEFO_PROV_SEL'
  #DESCRIPCION: Consulta de datos de proveedores a partir de una vista de base de datos
  #AUTOR:   rac
  #FECHA:   08-12-2011 10:44:58
  ***********************************/


  elseif(p_transaccion='SIGEFO_PROV_SEL')then

      begin


      	--Sentencia de la consulta
     	 v_consulta:='select
            			id_proveedor,
                        id_persona,
                        codigo,
                        numero_sigma,
                        tipo,
                        id_institucion,
                        desc_proveedor,
                        nit,
                        id_lugar,
                        lugar,
                        pais,
                        rotulo_comercial,
                        (COALESCE(email,''''))::varchar as email,
                        id_proveedor::INTEGER AS cod_proveedor
            from param.vproveedor provee
            where  ';

            if pxp.f_existe_parametro(p_tabla,'id_lugar') then
      			v_ids = param.f_get_id_lugares(v_parametros.id_lugar);
      			v_consulta = v_consulta || 'provee.id_lugar in ('||v_ids||') and ';
      		end if;

      --Definicion de la respuesta
      v_consulta:=v_consulta||v_parametros.filtro;
      v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

      --Devuelve la respuesta
      return v_consulta;

    end;
  /*********************************
  #TRANSACCION:  'SIGEFO_PROV_CONT'
  #DESCRIPCION: Conteo de registros de proveedores en la vista vproveedor
  #AUTOR:   rac
  #FECHA:   09-12-2011 10:44:58
  ***********************************/

  elsif(p_transaccion='SIGEFO_PROV_CONT')then

    begin
      --Sentencia de la consulta de conteo de registros
      v_consulta:='select count(id_proveedor)
              from param.vproveedor provee
              where ';

			if pxp.f_existe_parametro(p_tabla,'id_lugar') then
      			v_ids = param.f_get_id_lugares(v_parametros.id_lugar);

      			v_consulta = v_consulta || 'provee.id_lugar in ('||v_ids||') and ';
      		end if;

      --Definicion de la respuesta
      v_consulta:=v_consulta||v_parametros.filtro;

      --Devuelve la respuesta
      return v_consulta;

    end;
    /*********************************
  #TRANSACCION:  'CUESTIONARIO_SEL'
  #DESCRIPCION: Lista de cuestionario
  #AUTOR:   JUAN
  #FECHA:   20-11-2017 10:44:58
  ***********************************/


  elseif(p_transaccion='CUESTIONARIO_SEL')then

      begin
                --RAISE EXCEPTION 'error provocado por juan %',v_parametros.tipo;
				v_consulta1 :='';
                v_consulta1 := v_consulta1 || 'CREATE TEMP TABLE ttemporal(id_temporal SERIAL,
                                                                                id_pregunta INTEGER,
                                                                                pregunta VARCHAR,
                                                                                respuesta VARCHAR,
                                                                                tipo VARCHAR,
                                                                                nivel VARCHAR,
                                                                                id_usuario_reg INTEGER,
                                                                                id_curso INTEGER,
                                                                                id_usuario INTEGER,
                                                                                tipo_cuestionario VARCHAR) ON COMMIT DROP';
                EXECUTE(v_consulta1);

                FOR item IN(SELECT c.id_categoria,c.categoria,c.tipo,1 as nivel ,c.id_usuario_reg,usu1.cuenta
                            FROM sigefo.tcategoria c
                            inner join segu.tusuario usu1 on usu1.id_usuario = c.id_usuario_reg
                            where c.tipo=''||v_parametros.tipo||'' and c.habilitado=TRUE order by c.id_categoria) LOOP

                          v_consulta2 :='';
                          v_consulta2 := v_consulta2 ||'INSERT INTO ttemporal  (id_pregunta,
                                                                                pregunta,
                                                                                respuesta,
                                                                                tipo,
                                                                                nivel,
                                                                                id_usuario_reg,
                                                                                id_curso,
                                                                                id_usuario,
                                                                                tipo_cuestionario)VALUES';

                          v_consulta2 :=v_consulta2||'('||item.id_categoria||','''|| item.categoria||''','''||''||''','''||item.tipo||''','''||item.nivel||''','''|| item.id_usuario_reg||''','||v_parametros.id_curso||','||v_parametros.id_usuario::INTEGER||','''||v_parametros.tipo::varchar ||''')';
                           execute(v_consulta2);

                           FOR item1 IN(SELECT p.id_pregunta,p.pregunta,p.tipo,2 as nivel,p.id_usuario_reg,usu1.cuenta,
                                                (SELECT
                                                (case WHEN (cfe.cod_respuesta=1 and pp.tipo='Selección')then
                                                'Muy bueno'
                                                ELSE
                                                    case when (cfe.cod_respuesta=2 and pp.tipo='Selección')then
                                                    'Bueno'
                                                    else
                                                        case when (cfe.cod_respuesta=3 and pp.tipo='Selección')then
                                                        'Regular'
                                                        else
                                                            case when (cfe.cod_respuesta=4 and pp.tipo='Selección')then
                                                            'Insuficiente'
                                                            else
                                                                case when (pp.tipo='Texto')then
                                                                cfe.respuesta_texto
                                                                else
                                                                ''
                                                                end
                                                            end
                                                        end
                                                    end
                                                end)
                                                FROM sigefo.tcurso_funcionario_eval  cfe
                                                join sigefo.tpreguntas pp on pp.id_pregunta=cfe.id_pregunta
                                                join sigefo.tcurso cc on cc.id_curso=cfe.id_curso
                                                where cfe.id_pregunta=p.id_pregunta and cfe.id_curso=v_parametros.id_curso::INTEGER  and cfe.id_funcionario=(select cff.id_funcionario from sigefo.tcurso_funcionario cff
                                                                                                                                                              join sigefo.tcurso scuu on scuu.id_curso=cff.id_curso
                                                                                                                                                              join orga.tfuncionario ff on ff.id_funcionario=cff.id_funcionario
                                                                                                                                                              join segu.vpersona pp on pp.id_persona=ff.id_persona
                                                                                                                                                              join segu.tusuario usu11 on usu11.id_persona = pp.id_persona
                                                                                                                                                              where usu11.id_usuario=v_parametros.id_usuario::INTEGER  and scuu.id_curso=v_parametros.id_curso::INTEGER) )::varchar as respuesta
                                        from sigefo.tpreguntas p
                                        inner join segu.tusuario usu1 on usu1.id_usuario = p.id_usuario_reg
                                        where p.id_categoria=item.id_categoria and p.habilitado=TRUE order by p.pregunta) LOOP

                                    v_consulta2 :='';
                                    v_consulta2 := v_consulta2 || 'INSERT INTO ttemporal (id_pregunta,
                                                                                          pregunta,
                                                                                          respuesta,
                                                                                          tipo,
                                                                                          nivel,
                                                                                          id_usuario_reg,
                                                                                          id_curso,
                                                                                          id_usuario,
                                                                                          tipo_cuestionario)values';
                                    v_consulta1:='';
                                    if(item1.respuesta is null)then
                                       v_consulta1:='';
                                       else
                                       v_consulta1:=item1.respuesta;
                                    end if;
                                    v_consulta2 :=v_consulta2||'('||item1.id_pregunta||','''|| item1.pregunta||''','''||v_consulta1::varchar||''','''||item1.tipo||''','''||item1.nivel||''','''|| item1.id_usuario_reg||''','||v_parametros.id_curso||','||v_parametros.id_usuario::INTEGER||','''||v_parametros.tipo::varchar ||''')';
                                    execute(v_consulta2);
                           END LOOP;
           		END LOOP;


      	--Sentencia de la consulta
     	 v_consulta:='SELECT * FROM ttemporal WHERE ';

      --Definicion de la respuesta
      v_consulta:=v_consulta||v_parametros.filtro;
      v_consulta:=v_consulta||' order by  ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

      --Devuelve la respuesta
      return v_consulta;

    end;
  /*********************************
  #TRANSACCION:  'CUESTIONARIO_CONT'
  #DESCRIPCION: Conteo de registros de cuestionario
  #AUTOR:   JUAN
  #FECHA:   20-11-2017 10:44:58
  ***********************************/

  elsif(p_transaccion='CUESTIONARIO_CONT')then

    begin
      --Sentencia de la consulta de conteo de registros
      v_consulta:='SELECT COUNT(c.id_categoria)
                  FROM sigefo.tcategoria c
                  inner join segu.tusuario usu1 on usu1.id_usuario = c.id_usuario_reg
                  JOIN sigefo.tpreguntas p ON P.id_categoria=C.id_categoria
                  where c.tipo= '''||v_parametros.tipo||''' and c.habilitado=TRUE AND ';

      --Definicion de la respuesta
      v_consulta:=v_consulta||v_parametros.filtro;
      --Devuelve la respuesta
      return v_consulta;

    end;
    /*********************************
  #TRANSACCION:  'CUEST_PROV_SEL'
  #DESCRIPCION: Lista de cuestionario proveedor
  #AUTOR:   JUAN
  #FECHA:   20-11-2017 10:44:58
  ***********************************/


  elseif(p_transaccion='CUEST_PROV_SEL')then

      begin
                --RAISE EXCEPTION 'error provocado por juan %',v_parametros.id_usuario;
				v_consulta1 :='';
                v_consulta1 := v_consulta1 || 'CREATE TEMP TABLE ttemporal(id_temporal SERIAL,
                                                                                id_pregunta INTEGER,
                                                                                pregunta VARCHAR,
                                                                                respuesta VARCHAR,
                                                                                tipo VARCHAR,
                                                                                nivel VARCHAR,
                                                                                id_usuario_reg INTEGER,
                                                                                id_curso INTEGER,
                                                                                id_proveedor INTEGER) ON COMMIT DROP';
                EXECUTE(v_consulta1);

                FOR item IN(SELECT c.id_categoria,c.categoria,c.tipo,1 as nivel ,c.id_usuario_reg,usu1.cuenta
                            FROM sigefo.tcategoria c
                            inner join segu.tusuario usu1 on usu1.id_usuario = c.id_usuario_reg
                            where c.tipo=''||v_parametros.tipo||'' and c.habilitado=TRUE order by c.id_categoria) LOOP

                          v_consulta2 :='';
                          v_consulta2 := v_consulta2 ||'INSERT INTO ttemporal  (id_pregunta,
                                                                                pregunta,
                                                                                respuesta,
                                                                                tipo,
                                                                                nivel,
                                                                                id_usuario_reg,
                                                                                id_curso,
                                                                                id_proveedor)VALUES';

                          v_consulta2 :=v_consulta2||'('||item.id_categoria||','''|| item.categoria||''','''||''||''','''||item.tipo||''','''||item.nivel||''','''|| item.id_usuario_reg||''','||v_parametros.id_curso||','||v_parametros.id_proveedor::INTEGER ||')';
                           execute(v_consulta2);

                           FOR item1 IN(SELECT p.id_pregunta,p.pregunta,p.tipo,2 as nivel,p.id_usuario_reg,usu1.cuenta,
                                                (SELECT
                                                (case WHEN (cpe.cod_respuesta=1 and pp.tipo='Selección')then
                                                'Muy bueno'
                                                ELSE
                                                    case when (cpe.cod_respuesta=2 and pp.tipo='Selección')then
                                                    'Bueno'
                                                    else
                                                        case when (cpe.cod_respuesta=3 and pp.tipo='Selección')then
                                                        'Regular'
                                                        else
                                                            case when (cpe.cod_respuesta=4 and pp.tipo='Selección')then
                                                            'Insuficiente'
                                                            else
                                                                case when (pp.tipo='Texto')then
                                                                cpe.respuesta_texto
                                                                else
                                                                ''
                                                                end
                                                            end
                                                        end
                                                    end
                                                end)
                                                FROM sigefo.tcurso_proveedor_eval  cpe
                                                join sigefo.tpreguntas pp on pp.id_pregunta=cpe.id_pregunta
                                                join sigefo.tcurso cc on cc.id_curso=cpe.id_curso
                                                where cpe.id_pregunta=p.id_pregunta and cpe.id_curso=v_parametros.id_curso::INTEGER  and cc.id_proveedor=v_parametros.id_proveedor::INTEGER )::varchar as respuesta
                                        from sigefo.tpreguntas p
                                        inner join segu.tusuario usu1 on usu1.id_usuario = p.id_usuario_reg
                                        where p.id_categoria=item.id_categoria and p.habilitado=TRUE order by p.pregunta) LOOP

                                    v_consulta2 :='';
                                    v_consulta2 := v_consulta2 || 'INSERT INTO ttemporal (id_pregunta,
                                                                                          pregunta,
                                                                                          respuesta,
                                                                                          tipo,
                                                                                          nivel,
                                                                                          id_usuario_reg,
                                                                                          id_curso,
                                                                                          id_proveedor)values';
                                    v_consulta1:='';
                                    if(item1.respuesta is null)then
                                       v_consulta1:='';
                                       else
                                       v_consulta1:=item1.respuesta;
                                    end if;
                                    v_consulta2 :=v_consulta2||'('||item1.id_pregunta||','''|| item1.pregunta||''','''||v_consulta1::varchar||''','''||item1.tipo||''','''||item1.nivel||''','''|| item1.id_usuario_reg||''','||v_parametros.id_curso||','||v_parametros.id_proveedor::INTEGER||')';
                                    execute(v_consulta2);
                           END LOOP;
           		END LOOP;


      	--Sentencia de la consulta
     	 v_consulta:='SELECT * FROM ttemporal WHERE ';

      --Definicion de la respuesta
      v_consulta:=v_consulta||v_parametros.filtro;
      v_consulta:=v_consulta||' order by  ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

      --Devuelve la respuesta
      return v_consulta;

    end;
  /*********************************
  #TRANSACCION:  'CUEST_PROV_CONT'
  #DESCRIPCION: Conteo de registros de cuestionario
  #AUTOR:   JUAN
  #FECHA:   20-11-2017 10:44:58
  ***********************************/

  elsif(p_transaccion='CUEST_PROV_CONT')then

    begin
      --Sentencia de la consulta de conteo de registros
      v_consulta:='SELECT COUNT(c.id_categoria)
                  FROM sigefo.tcategoria c
                  inner join segu.tusuario usu1 on usu1.id_usuario = c.id_usuario_reg
                  JOIN sigefo.tpreguntas p ON P.id_categoria=C.id_categoria
                  where c.tipo= '''||v_parametros.tipo||''' and c.habilitado=TRUE AND ';

      --Definicion de la respuesta
      v_consulta:=v_consulta||v_parametros.filtro;
      --Devuelve la respuesta
      return v_consulta;

    end;
    /*********************************
    #TRANSACCION:  'SIGEFO_SCU_ARB_SEL'
    #DESCRIPCION:	Seleccion de datos del arbol
    #AUTOR:		manu
    #FECHA:		03-07-2017 09:19:28
    ***********************************/

  	ELSEIF (p_transaccion = 'SIGEFO_SCU_ARB_SEL')
    	THEN
        	BEGIN
                      v_consulta:='SELECT c.id_curso,c.nombre_curso,c.cod_prioridad,c.horas,
                                  (SELECT count(cfuncio.id_funcionario) from sigefo.tcurso_funcionario cfuncio where cfuncio.id_curso=c.id_curso)::INTEGER as cantidad_personas,
                                  c.peso
                                  from sigefo.tcurso c
                                  WHERE';
                RETURN v_consulta;
		    END;
    /*********************************
    #TRANSACCION:  'PM_FUNCIO_SEL'
    #DESCRIPCION:	Consulta de datos
    #AUTOR:		JUAN
    #FECHA:		29-08-2011 09:19:28
    ***********************************/

    ELSEIF (p_transaccion = 'PM_FUNCIO_SEL')
    	THEN
			BEGIN

        		v_consulta:='SELECT

                            f.id_funcionario::INTEGER,
                            f.codigo::VARCHAR,
                            p.nombre_completo2::VARCHAR AS desc_person,
                            p.ci::varchar
                            FROM orga.tcargo c
                             JOIN orga.tuo tu on tu.id_uo=c.id_uo
                             JOIN orga.tuo_funcionario tf ON tf.id_cargo=c.id_cargo AND tf.fecha_asignacion<=CURRENT_DATE AND (tf.fecha_finalizacion IS NULL OR CURRENT_DATE<=tf.fecha_finalizacion)
                             JOIN orga.tfuncionario f on f.id_funcionario = tf.id_funcionario
                             JOIN segu.vpersona p on p.id_persona=f.id_persona
                            WHERE tu.estado_reg=''activo'' and  c.fecha_ini<=CURRENT_DATE AND (c.fecha_fin IS NULL OR CURRENT_DATE<=c.fecha_fin)
							and';

                v_consulta:=v_consulta || v_parametros.filtro;
                v_consulta:=
                v_consulta || ' order by ' || v_parametros.ordenacion || ' ' || v_parametros.dir_ordenacion || ' limit ' ||
                v_parametros.cantidad || ' offset ' || v_parametros.puntero;
        		RETURN v_consulta;
      		END;
      /*********************************
      #TRANSACCION:  'PM_FUNCIO_CONT'
      #DESCRIPCION: Conteo de registros de FUNCIONARIOS ASOCIADOS A LA UNIDAD ORGANIZACIONAL SELECCIONADO EN CURSO
      #AUTOR:   JUAN
      #FECHA:   09-12-2011 10:44:58
      ***********************************/

      elsif(p_transaccion='PM_FUNCIO_CONT')then

        begin
          --Sentencia de la consulta de conteo de registros
          v_consulta:='SELECT count(p.nombre_completo2)
FROM orga.tcargo c
JOIN orga.tuo tu on tu.id_uo=c.id_uo
JOIN orga.tuo_funcionario tf ON tf.id_cargo=c.id_cargo AND tf.fecha_asignacion<=CURRENT_DATE AND (tf.fecha_finalizacion IS NULL OR CURRENT_DATE<=tf.fecha_finalizacion)
JOIN orga.tfuncionario f on f.id_funcionario = tf.id_funcionario
JOIN segu.vpersona p on p.id_persona=f.id_persona
JOIN sigefo.tcargo_competencia cc on cc.id_cargo=c.id_cargo and c.id_uo=tu.id_uo
WHERE tu.estado_reg=''activo'' and  c.fecha_ini<=CURRENT_DATE AND (c.fecha_fin IS NULL OR CURRENT_DATE<=c.fecha_fin)
and ';

          --Definicion de la respuesta
          v_consulta:=v_consulta||v_parametros.filtro;

          --Devuelve la respuesta
          return v_consulta;

        end;
    /******************************************/
	ELSE
    	RAISE EXCEPTION 'Transaccion inexistente';
  	END IF;

	EXCEPTION
		WHEN OTHERS
          THEN
            v_resp='';
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
            v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
            v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
            RAISE EXCEPTION '%',v_resp;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;