CREATE OR REPLACE FUNCTION sigefo.f_llenado_valores_avance_real (
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		SIGECO
 FUNCION: 		sigefo.f_llenado_valores_avance_real
 DESCRIPCION:   Funcion para el llenado en la tabla tavance_real para realizar pruebas, no se usa para ninguna funcionalidad en sistema
 AUTOR: 		 (JUAN)
 FECHA:	        16-11-2017 20:20:49
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

  v_nro_requerimiento INTEGER;
  v_id_requerimiento  INTEGER;
  v_resp              VARCHAR;
  v_nombre_funcion    TEXT;
  v_mensaje_error     TEXT;
  v_id_linea          INTEGER;
  v_id_linea_padre    INTEGER;
  va_id_funcionarios  VARCHAR [];
  v_id_funcionario    INTEGER;
  
  v_gestion_inicio    date;
  v_gestion_fin       date;
  v_valor_frecuencia  text;
  v_gestion_contador  date;
  v_meses             text;
  item                RECORD;

BEGIN


  /*********************************
   #TRANSACCION:  'SSIG_LINEA_INS'
   #DESCRIPCION:	Insercion de registros
   #AUTOR:		admin
   #FECHA:		11-04-2017 20:20:49
  ***********************************/

  IF (0=0)
  THEN

    BEGIN



--iniciar funcion de linea
for item in (SELECT c.id_curso, c.id_gestion,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod FROM sigefo.tcurso c)LOOP

            --Insertado de meses en la tabla tavance_real
             v_gestion_inicio :=(select g.fecha_ini from  param.tgestion g  WHERE g.id_gestion=item.id_gestion);   
             v_gestion_fin :=(select g.fecha_fin from  param.tgestion g  WHERE g.id_gestion=item.id_gestion);
             v_valor_frecuencia := '1' || ' MONTH';
             v_meses :='';
                 WHILE ((SELECT CAST(v_gestion_inicio AS DATE)) <= v_gestion_fin ) LOOP
                 
      	IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=1) THEN
        v_meses :=  'Ene'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	
            INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=2) THEN
        v_meses :=  'Feb'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=3) THEN
        v_meses :=  'Mar'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=4) THEN
        v_meses :=  'Abr'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=5) THEN
        v_meses :=  'May'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF; 
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=6) THEN
        v_meses :=  'Jun'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=7) THEN
        v_meses :=  'Jul'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=8) THEN
        v_meses :=  'Ago'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=9) THEN
        v_meses :=  'Sep'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=10) THEN
        v_meses :=  'Oct'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=11) THEN
        v_meses :=  'Nov'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        --
        IF((SELECT date_part('month',CAST(v_gestion_inicio AS DATE)))=12) THEN
        v_meses :=  'Dic'|| (SELECT substring( date_part('year',CAST(v_gestion_inicio AS DATE))::VARCHAR from 3 for 4));
        	INSERT INTO sigefo.tavance_real(id_curso,mes, avance_real,estado_reg,id_usuario_reg,usuario_ai,fecha_reg,id_usuario_mod) 
        	                          VALUES(item.id_curso::INTEGER,v_meses::VARCHAR,0,'activo'::VARCHAR,item.id_usuario_reg,item.usuario_ai,item.fecha_reg,item.id_usuario_mod);
      	END IF;
        v_gestion_contador=(SELECT CAST(v_gestion_inicio AS DATE) + CAST(v_valor_frecuencia AS INTERVAL));         
        v_gestion_inicio=v_gestion_contador;
      END LOOP;
            --fin insetado de avance_real  
              
      end loop;


      --Definicion de la respuesta
      v_resp = pxp.f_agrega_clave(v_resp, 'mensaje',
                                  'Definición de líneas almacenado(a) con exito (id_linea' || v_id_linea || ')');
      v_resp = pxp.f_agrega_clave(v_resp, 'id_linea', v_id_linea :: VARCHAR);

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

ALTER FUNCTION sigefo.f_llenado_valores_avance_real ()
  OWNER TO postgres;