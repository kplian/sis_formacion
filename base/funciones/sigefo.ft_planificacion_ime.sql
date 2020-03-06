--------------- SQL ---------------

CREATE OR REPLACE FUNCTION sigefo.ft_planificacion_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_planificacion_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigefo.tplanificacion'
 AUTOR: 		 (admin)
 FECHA:	        26-04-2017 20:37:24
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 ISSUE            FECHA:		      AUTOR                 DESCRIPCION
#7               05/03/2020          JJA                   agregar gestión en competencias
***************************************************************************/

DECLARE

  v_nro_requerimiento INTEGER;
  v_parametros        RECORD;
  v_id_requerimiento  INTEGER;
  v_resp              VARCHAR;
  v_nombre_funcion    TEXT;
  v_mensaje_error     TEXT;
  v_id_planificacion  INTEGER;
  va_cod_criterios    VARCHAR [];
  v_cod_criterio      VARCHAR;
  va_id_competencias  VARCHAR [];
  v_id_competencia    INTEGER;
  va_id_cargos        VARCHAR [];
  v_id_cargo          INTEGER;
  va_id_proveedores   VARCHAR [];
  v_id_proveedor      INTEGER;
  va_id_uos   VARCHAR [];
  v_id_uo      INTEGER;
  v_total		INTEGER;
  v_consulta   varchar;
  v_sw 			VARCHAR;


BEGIN

  v_nombre_funcion = 'sigefo.ft_planificacion_ime';
  v_parametros = pxp.f_get_record(p_tabla);

  /*********************************
   #TRANSACCION:  'SIGEFO_SIGEFOP_INS'
   #DESCRIPCION:	Insercion de registros
   #AUTOR:		admin
   #FECHA:		26-04-2017 20:37:24
  ***********************************/

  IF (p_transaccion = 'SIGEFO_SIGEFOP_INS')
  THEN

    BEGIN
      --Sentencia de la insercion
      INSERT INTO sigefo.tplanificacion (
        id_gestion,
        estado_reg,
        cantidad_personas,
        contenido_basico,
        nombre_planificacion,
        necesidad,
        horas_previstas,
        fecha_reg,
        usuario_ai,
        id_usuario_reg,
        id_usuario_ai,
        id_usuario_mod,
        fecha_mod,
        id_proveedor,
        cantidad_cursos_asociados --#7
      ) VALUES (
        v_parametros.id_gestion,
        'activo',
        v_parametros.cantidad_personas,
        v_parametros.contenido_basico,
        v_parametros.nombre_planificacion,
        v_parametros.necesidad,
        v_parametros.horas_previstas,
        now(),
        v_parametros._nombre_usuario_ai,
        p_id_usuario,
        v_parametros._id_usuario_ai,
        NULL,
        NULL,
        v_parametros.id_proveedor::INTEGER,
        v_parametros.cantidad_cursos_asociados ----#7
      )
      RETURNING id_planificacion
        INTO v_id_planificacion;

      -- Insertando los criterios

      va_cod_criterios := string_to_array(v_parametros.cod_criterio, ',');

      FOREACH v_cod_criterio IN ARRAY va_cod_criterios
      LOOP
        INSERT INTO sigefo.tplanificacion_criterio (
          id_usuario_reg,
          fecha_reg,
          estado_reg,
          id_usuario_ai,
          id_planificacion,
          cod_criterio
        )
        VALUES (
          p_id_usuario,
          now(),
          'activo',
          v_parametros._id_usuario_ai,
          v_id_planificacion,
          v_cod_criterio :: VARCHAR
        );
      END LOOP;

      -- Guardando las competencias asociadas a la planificacion
      -- la variable va_id_competencias es el id_competencia_nivel
      va_id_competencias := string_to_array(v_parametros.id_competencias, ',');

      FOREACH v_id_competencia IN ARRAY va_id_competencias
      LOOP
        INSERT INTO sigefo.tplanificacion_competencia (
          id_usuario_reg,
          fecha_reg,
          estado_reg,
          id_usuario_ai,
          id_planificacion,
          id_competencia,
          id_competencia_nivel
        )
        VALUES (
          p_id_usuario,
          now(),
          'activo',
          v_parametros._id_usuario_ai,
          v_id_planificacion,
          (SELECT cn.id_competencia from sigefo.tcompetencia_nivel cn where cn.id_competencia_nivel=v_id_competencia :: INTEGER),
          v_id_competencia :: INTEGER
        );

      END LOOP;

      -- Guardando las cargos asociadas a la planificacion
      /*va_id_cargos := string_to_array(v_parametros.id_cargos, ',');

      FOREACH v_id_cargo IN ARRAY va_id_cargos
      LOOP
        INSERT INTO sigefo.tplanificacion_cargo (
          id_usuario_reg,
          fecha_reg,
          estado_reg,
          id_usuario_ai,
          id_planificacion,
          id_cargo
        )
        VALUES (
          p_id_usuario,
          now(),
          'activo',
          v_parametros._id_usuario_ai,
          v_id_planificacion,
          v_id_cargo :: INTEGER
        );

      END LOOP;*/

      -- Guardando las proveedores asociadas a la planificacion
      /*va_id_proveedores := string_to_array(v_parametros.id_proveedores, ',');

      FOREACH v_id_proveedor IN ARRAY va_id_proveedores
      LOOP

        INSERT INTO sigefo.tplanificacion_proveedor (
          id_usuario_reg,
          fecha_reg,
          estado_reg,
          id_usuario_ai,
          id_planificacion,
          id_proveedor
        ) VALUES (
          p_id_usuario,
          now(),
          'activo',
          v_parametros._id_usuario_ai,
          v_id_planificacion,
          v_id_proveedor :: INTEGER
        );

      END LOOP;*/

      -- Guardando las gerencias asociadas a la planificacion
     /* va_id_uos := string_to_array(v_parametros.id_uo, ',');

      FOREACH v_id_uo IN ARRAY va_id_uos
      LOOP

        INSERT INTO sigefo.tplanificacion_uo (
          id_usuario_reg,
          fecha_reg,
          estado_reg,
          id_usuario_ai,
          id_planificacion,
          id_uo
        ) VALUES (
          p_id_usuario,
          now(),
          'activo',
          v_parametros._id_usuario_ai,
          v_id_planificacion,
          v_id_uo :: INTEGER
        );

      END LOOP;*/

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                  'Planificación almacenado(a) con exito (id_planificacion' || v_id_planificacion ||
                                  ')');
      v_resp = pxp.f_agrega_clave(v_resp, 'id_planificacion', v_id_planificacion :: VARCHAR);
      --Devuelve la respuesta
      RETURN v_resp;

    END;
    /*********************************
     #TRANSACCION:  'SIGEFO_SIGEFOP_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		JUAN
     #FECHA:		26-04-2017 20:37:24
    ***********************************/


  ELSIF (p_transaccion = 'SIGEFO_SIGEFOP_MOD')
    THEN

      BEGIN
        --Sentencia de la modificacion
        UPDATE sigefo.tplanificacion
        SET
          id_gestion           = v_parametros.id_gestion,
          cantidad_personas    = v_parametros.cantidad_personas,
          contenido_basico     = v_parametros.contenido_basico,
          nombre_planificacion = v_parametros.nombre_planificacion,
          necesidad            = v_parametros.necesidad,
          horas_previstas      = v_parametros.horas_previstas,
          id_usuario_mod       = p_id_usuario,
          fecha_mod            = now(),
          id_usuario_ai        = v_parametros._id_usuario_ai,
          usuario_ai           = v_parametros._nombre_usuario_ai,
          id_proveedor = v_parametros.id_proveedor::INTEGER,
          cantidad_cursos_asociados = v_parametros.cantidad_cursos_asociados --#7
        WHERE id_planificacion = v_parametros.id_planificacion;

        -- PLANIFICACION CRITERIO

        va_cod_criterios := string_to_array(v_parametros.cod_criterio, ',');

        -- Eliminando
        DELETE FROM sigefo.tplanificacion_criterio pc
        WHERE
          pc.id_planificacion = v_parametros.id_planificacion;

        -- Agregando
        FOREACH v_cod_criterio IN ARRAY va_cod_criterios
        LOOP
          INSERT INTO sigefo.tplanificacion_criterio (
            id_usuario_reg,
            fecha_reg,
            estado_reg,
            id_usuario_ai,
            id_planificacion,
            cod_criterio
          )
          VALUES (
            p_id_usuario,
            now(),
            'activo',
            v_parametros._id_usuario_ai,
            v_parametros.id_planificacion,
            v_cod_criterio :: VARCHAR
          );
        END LOOP;

        -- PLANIFICACION UOS(gerencias)
        -- Eliminando
        /*DELETE FROM sigefo.tplanificacion_uo puo
        WHERE puo.id_planificacion = v_parametros.id_planificacion;*/
        -- Insertando
      /*  va_id_uos := string_to_array(v_parametros.id_uo, ',');

        FOREACH v_id_uo IN ARRAY va_id_uos
        LOOP

          INSERT INTO sigefo.tplanificacion_uo (
            id_usuario_reg,
            fecha_reg,
            estado_reg,
            id_usuario_ai,
            id_planificacion,
            id_uo
          ) VALUES (
            p_id_usuario,
            now(),
            'activo',
            v_parametros._id_usuario_ai,
            v_parametros.id_planificacion,
            v_id_uo :: INTEGER
          );

        END LOOP;*/


        -- PLANIFICACION CARGOS
        -- Eliminando
      /*   DELETE FROM sigefo.tplanificacion_cargo pca
        WHERE pca.id_planificacion = v_parametros.id_planificacion;
        -- Insertando
        va_id_cargos := string_to_array(v_parametros.id_cargos, ',');

        FOREACH v_id_cargo IN ARRAY va_id_cargos
        LOOP
          INSERT INTO sigefo.tplanificacion_cargo (
            id_usuario_reg,
            fecha_reg,
            estado_reg,
            id_usuario_ai,
            id_planificacion,
            id_cargo
          )
          VALUES (
            p_id_usuario,
            now(),
            'activo',
            v_parametros._id_usuario_ai,
            v_parametros.id_planificacion,
            v_id_cargo :: INTEGER
          );

        END LOOP;*/

        -- PLANIFICACION COMPETENCIAS

        -- Eliminando
        DELETE FROM sigefo.tplanificacion_competencia pco
        WHERE pco.id_planificacion = v_parametros.id_planificacion;

        -- Insertanto
        -- la variable va_id_competencias es el id_competencia_nivel
        va_id_competencias := string_to_array(v_parametros.id_competencias, ',');

        FOREACH v_id_competencia IN ARRAY va_id_competencias
        LOOP
          INSERT INTO sigefo.tplanificacion_competencia (
            id_usuario_reg,
            fecha_reg,
            estado_reg,
            id_usuario_ai,
            id_planificacion,
            id_competencia,
            id_competencia_nivel
          )
          VALUES (
            p_id_usuario,
            now(),
            'activo',
            v_parametros._id_usuario_ai,
            v_parametros.id_planificacion,
            (SELECT cn.id_competencia from sigefo.tcompetencia_nivel cn where cn.id_competencia_nivel=v_id_competencia :: INTEGER),
            v_id_competencia :: INTEGER
          );

        END LOOP;

        -- PLANIFICACION PROVEEDORES

        -- Eliminando
     /*   DELETE FROM sigefo.tplanificacion_proveedor pp
        WHERE pp.id_planificacion = v_parametros.id_planificacion;

        -- Insertando
        va_id_proveedores := string_to_array(v_parametros.id_proveedores, ',');

        FOREACH v_id_proveedor IN ARRAY va_id_proveedores
        LOOP

          INSERT INTO sigefo.tplanificacion_proveedor (
            id_usuario_reg,
            fecha_reg,
            estado_reg,
            id_usuario_ai,
            id_planificacion,
            id_proveedor
          ) VALUES (
            p_id_usuario,
            now(),
            'activo',
            v_parametros._id_usuario_ai,
            v_parametros.id_planificacion,
            v_id_proveedor :: INTEGER
          );

        END LOOP;*/

        --Definicion de la respuesta
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Planificación modificado(a)');
        v_resp = pxp.f_agrega_clave(v_resp, 'id_planificacion', v_parametros.id_planificacion :: VARCHAR);

        --Devuelve la respuesta
        RETURN v_resp;

      END;

      /*********************************
       #TRANSACCION:  'SIGEFO_SIGEFOP_ELI'
       #DESCRIPCION:	Eliminacion de registros
       #AUTOR:		admin
       #FECHA:		26-04-2017 20:37:24
      ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_SIGEFOP_ELI')
    THEN

      BEGIN
        --Sentencia de la eliminacion
	    v_total = (SELECT COUNT(*) FROM sigefo.tcurso WHERE id_planificacion=v_parametros.id_planificacion);
        v_sw :='';
        IF (v_total = 0)
        	THEN
              DELETE
              FROM  sigefo.tplanificacion sigefop
              WHERE sigefop.id_planificacion=v_parametros.id_planificacion;

              v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Planificación eliminado(a)');
       		  v_resp = pxp.f_agrega_clave(v_resp, 'id_planificacion', v_parametros.id_planificacion :: VARCHAR);
        ELSE
        	RAISE EXCEPTION 'Error!! La planificacion esta registrado en curso ';
		END IF;

		RETURN v_resp;
      END;
      /*********************************
       #TRANSACCION:  'SIGEFO_APROB_PLA'
       #DESCRIPCION:	Aprobar planificacion
       #AUTOR:		JUAN
       #FECHA:		29-11-2017 20:37:24
      ***********************************/

      ELSIF (p_transaccion = 'SIGEFO_APROB_PLA')
        THEN

          BEGIN
            --Sentencia de la eliminacion


            IF(SELECT count(p.codigo) from segu.tusuario u
              join segu.tusuario_rol ur on ur.id_usuario=u.id_usuario
              join segu.trol r on r.id_rol=ur.id_rol
              join segu.trol_procedimiento_gui rpg on rpg.id_rol=r.id_rol
              join segu.tprocedimiento_gui pg on pg.id_procedimiento_gui=rpg.id_procedimiento_gui
              join segu.tprocedimiento p on p.id_procedimiento=pg.id_procedimiento
              join segu.tgui g on g.id_gui= pg.id_gui
              where u.id_usuario=v_parametros.id_usuario::INTEGER and p.codigo=v_parametros.transaccion::VARCHAR)then

                  IF (v_parametros.aprobado=1)THEN
                        UPDATE  sigefo.tplanificacion
                        SET aprobado=TRUE
                        WHERE id_planificacion=v_parametros.id_planificacion;
                  ELSE
                        UPDATE  sigefo.tplanificacion
                        SET aprobado=FALSE
                        WHERE id_planificacion=v_parametros.id_planificacion;
                  END IF;
            ELSE
                  RAISE EXCEPTION 'El usuario no tiene permiso a la funcion % ',v_parametros.transaccion;
            end if;

            v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Planificación aprobado(a)');
            v_resp = pxp.f_agrega_clave(v_resp, 'id_planificacion', v_parametros.id_planificacion :: VARCHAR);

            RETURN v_resp;
          END;

  ELSE

    RAISE EXCEPTION 'Transaccion inexistente: ';

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