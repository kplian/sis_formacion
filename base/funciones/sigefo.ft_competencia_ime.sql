CREATE OR REPLACE FUNCTION sigefo.ft_competencia_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de gestión de la formación
 FUNCION: 		sigefo.ft_competencia_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigefo.tcompetencia'
 AUTOR: 		 (admin)
 FECHA:	        04-05-2017 19:30:13
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

  v_nro_requerimiento            INTEGER;
  v_parametros                   RECORD;
  v_id_requerimiento             INTEGER;
  v_resp                         VARCHAR;
  v_nombre_funcion               TEXT;
  v_mensaje_error                TEXT;
  v_id_competencia               INTEGER;

  j_cargos                       JSON;
  j_id_cargos                    JSON;
  j_competencias                 JSON;
  j_id_competencias              JSON;

  v_validar_cargo_competencia    INTEGER;
  v_cargo_competencia_duplicados TEXT;

BEGIN
  v_nombre_funcion = 'sigefo.ft_competencia_ime';
  v_parametros = pxp.f_get_record(p_tabla);

  /*********************************
   #TRANSACCION:  'SIGEFO_SIGEFOCO_INS'
   #DESCRIPCION:	Insercion de registros
   #AUTOR:		admin
   #FECHA:		04-05-2017 19:30:13
  ***********************************/

  IF (p_transaccion = 'SIGEFO_SIGEFOCO_INS')
  THEN

    BEGIN
      --Sentencia de la insercion
      INSERT INTO sigefo.tcompetencia (
        tipo,
        estado_reg,
        competencia,
        id_usuario_ai,
        id_usuario_reg,
        fecha_reg,
        usuario_ai,
        id_usuario_mod,
        fecha_mod
      ) VALUES (
        v_parametros.tipo,
        'activo',
        v_parametros.competencia,
        v_parametros._id_usuario_ai,
        p_id_usuario,
        now(),
        v_parametros._nombre_usuario_ai,
        NULL,
        NULL


      )
      RETURNING id_competencia
        INTO v_id_competencia;

      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                  'Competencias almacenado(a) con exito (id_competencia' || v_id_competencia || ')');
      v_resp = pxp.f_agrega_clave(v_resp, 'id_competencia', v_id_competencia :: VARCHAR);

      --Devuelve la respuesta
      RETURN v_resp;

    END;

    /*********************************
     #TRANSACCION:  'SIGEFO_SIGEFOCO_MOD'
     #DESCRIPCION:	Modificacion de registros
     #AUTOR:		admin
     #FECHA:		04-05-2017 19:30:13
    ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_SIGEFOCO_MOD')
    THEN

      BEGIN
        --Sentencia de la modificacion
        --raise exception '%',v_parametros.tipo;
        UPDATE sigefo.tcompetencia
        SET
          tipo           = v_parametros.tipo,
          competencia    = v_parametros.competencia,
          id_usuario_mod = p_id_usuario,
          fecha_mod      = now(),
          id_usuario_ai  = v_parametros._id_usuario_ai,
          usuario_ai     = v_parametros._nombre_usuario_ai
        WHERE id_competencia = v_parametros.id_competencia;

        --Definicion de la respuesta
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Competencias modificado(a)');
        v_resp = pxp.f_agrega_clave(v_resp, 'id_competencia', v_parametros.id_competencia :: VARCHAR);

        --Devuelve la respuesta
        RETURN v_resp;

      END;

      /*********************************
       #TRANSACCION:  'SIGEFOCCO_INS'
       #DESCRIPCION:	Insertar la tabla cargo competencia
       #AUTOR:		Juan
       #FECHA:		11-05-2017 19:30:13
      ***********************************/

  ELSIF (p_transaccion = 'SIGEFOCCO_INS')
    THEN

      BEGIN
        j_id_cargos := v_parametros.cod_cargos;

        FOR j_cargos IN (SELECT *
                         FROM json_array_elements(j_id_cargos)) LOOP
          --   raise NOTICE '%',  (j_cargos ->> 'cod_cargo');
          j_id_competencias := v_parametros.cod_competencias;
          FOR j_competencias IN (SELECT *
                                 FROM json_array_elements(j_id_competencias)) LOOP


            --   v_cargo_competencia_duplicados text;

            v_validar_cargo_competencia = (SELECT count(cc.id_cargo)
                                           FROM sigefo.tcargo_competencia cc
                                           WHERE cc.id_cargo = (j_cargos ->> 'cod_cargo') :: INTEGER AND
                                                 cc.id_competencia = (j_competencias ->> 'cod_competencia') :: INTEGER);
            IF (v_validar_cargo_competencia > 0)
            THEN

              v_cargo_competencia_duplicados = (v_cargo_competencia_duplicados ||
                                                (SELECT (cargo.nombre || ' => ' || c.competencia)
                                                 FROM sigefo.tcargo_competencia cc
                                                   JOIN sigefo.tcompetencia c ON c.id_competencia = cc.id_competencia
                                                   JOIN orga.tcargo cargo ON cargo.id_cargo = cc.id_cargo
                                                 WHERE cc.id_cargo = (j_cargos ->> 'cod_cargo') :: INTEGER AND
                                                       cc.id_competencia =
                                                       (j_competencias ->> 'cod_competencia') :: INTEGER)) :: VARCHAR;

            ELSE
              INSERT INTO sigefo.tcargo_competencia (
                id_cargo,
                id_competencia,
                estado_reg,
                id_usuario_ai,
                id_usuario_reg,
                fecha_reg,
                usuario_ai,
                id_usuario_mod,
                fecha_mod
              ) VALUES (
                (j_cargos ->> 'cod_cargo') :: INTEGER,
                (j_competencias ->> 'cod_competencia') :: INTEGER,
                'activo',
                v_parametros._id_usuario_ai,
                p_id_usuario,
                now(),
                v_parametros._nombre_usuario_ai,
                NULL,
                NULL
              );

            END IF;


          END LOOP;
        END LOOP;

        --Devuelve la respuesta
        --  raise EXCEPTION 'juan error ';
        RETURN v_resp;

      END;

      /*********************************
       #TRANSACCION:  'SIGEFO_ECCOMPETENCIA'
       #DESCRIPCION:	Eliminacion de CARGO COMPETENCIA
       #AUTOR:		JUAN
       #FECHA:		17-05-2017 20:25:54
      ***********************************/

  ELSIF (p_transaccion = 'SIGEFO_ECCOMPETENCIA')
    THEN

      BEGIN
        --Sentencia de la eliminacion
        j_id_competencias := v_parametros.cod_competencias;
        FOR j_competencias IN (SELECT *
                               FROM json_array_elements(j_id_competencias)) LOOP
          DELETE FROM sigefo.tcargo_competencia
          WHERE id_cargo = v_parametros.id_cargo AND id_competencia = (j_competencias ->> 'cod_competencia') :: INTEGER;
        END LOOP;
        --Definicion de la respuesta
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'cargo competencia eliminado(a)');
        v_resp = pxp.f_agrega_clave(v_resp, 'id_cargo', v_parametros.id_cargo :: VARCHAR);

        --Devuelve la respuesta

        --RAISE NOTICE 'preuba cargo % ', v_parametros.id_cargo;

        -- RAISE EXCEPTION 'error juan';
        RETURN v_resp;

      END;

  ELSIF (p_transaccion = 'SIGEFO_SIGEFOCO_ELI')
    THEN

      BEGIN
        --Sentencia de la eliminacion
        DELETE FROM sigefo.tcompetencia
        WHERE id_competencia = v_parametros.id_competencia;

        --Definicion de la respuesta
        v_resp = pxp.f_agrega_clave(v_resp, 'mensaje', 'Competencias eliminado(a)');
        v_resp = pxp.f_agrega_clave(v_resp, 'id_competencia', v_parametros.id_competencia :: VARCHAR);

        --Devuelve la respuesta
        RETURN v_resp;

      END;

  ELSE

    RAISE EXCEPTION 'Transaccion inexistente: %', p_transaccion;

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