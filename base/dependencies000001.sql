/***********************************I-DEP-YAC-SIGEFO-0-02/05/2017*****************************************/

select pxp.f_insert_testructura_gui ('SIGEFO', 'SISTEMA');

ALTER TABLE sigefo.tplanificacion
  ADD CONSTRAINT tplanificacion_fk FOREIGN KEY (id_gestion)
    REFERENCES param.tgestion(id_gestion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
/***********************************F-DEP-YAC-SIGEFO-0-02/05/2017*****************************************/
/***********************************I-DEP-YAC-SIGEFO-0-04/05/2017*****************************************/

 
ALTER TABLE sigefo.tcargo_competencia
  ADD CONSTRAINT tcargo_competencia_fk FOREIGN KEY (id_cargo)
REFERENCES orga.tcargo(id_cargo)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;


ALTER TABLE sigefo.tcargo_competencia
  ADD CONSTRAINT tcargo_competencia_fk1 FOREIGN KEY (id_competencia)
REFERENCES sigefo.tcompetencia(id_competencia)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;


ALTER TABLE sigefo.tplanificacion_competencia
  ADD CONSTRAINT tplanificacion_competencia_fk FOREIGN KEY (id_planificacion)
REFERENCES sigefo.tplanificacion(id_planificacion)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;


ALTER TABLE sigefo.tplanificacion_competencia
  ADD CONSTRAINT tplanificacion_competencia_fk1 FOREIGN KEY (id_competencia)
REFERENCES sigefo.tcompetencia(id_competencia)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;


ALTER TABLE sigefo.tplanificacion_cargo
  ADD CONSTRAINT tplanificacion_cargo_fk FOREIGN KEY (id_planificacion)
REFERENCES sigefo.tplanificacion(id_planificacion)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;


ALTER TABLE sigefo.tplanificacion_cargo
  ADD CONSTRAINT tplanificacion_cargo_fk1 FOREIGN KEY (id_cargo)
REFERENCES orga.tcargo(id_cargo)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

/***********************************F-DEP-YAC-SIGEFO-0-04/05/2017*****************************************/
/***********************************I-DEP-YAC-SIGEFO-0-05/05/2017*****************************************/

select pxp.f_insert_testructura_gui ('SIGEFOP', 'SIGEFO');
select pxp.f_insert_testructura_gui ('SIGEFOCO', 'SIGEFO');

/***********************************F-DEP-YAC-SIGEFO-0-05/05/2017*****************************************/



/***********************************I-DEP-JUAN-SIGEFO-0-05/05/2017*****************************************/

ALTER TABLE sigefo.tcurso
  ADD CONSTRAINT tcurso_fk FOREIGN KEY (id_gestion)
    REFERENCES param.tgestion(id_gestion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

ALTER TABLE sigefo.tcurso
  ADD CONSTRAINT tcurso_fk1 FOREIGN KEY (id_lugar)
    REFERENCES param.tlugar(id_lugar)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

ALTER TABLE sigefo.tcurso
  ADD CONSTRAINT tcurso_fk2 FOREIGN KEY (id_proveedor)
    REFERENCES param.tproveedor(id_proveedor)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    


ALTER TABLE sigefo.tcurso_competencia
  ADD CONSTRAINT tcurso_competencia_fk FOREIGN KEY (id_curso)
    REFERENCES sigefo.tcurso(id_curso)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

ALTER TABLE sigefo.tcurso_competencia
  ADD CONSTRAINT tcurso_competencia_fk1 FOREIGN KEY (id_competencia)
    REFERENCES sigefo.tcompetencia(id_competencia)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE; 
    

ALTER TABLE sigefo.tcurso_planificacion
  ADD CONSTRAINT tcurso_planificacion_fk FOREIGN KEY (id_curso)
    REFERENCES sigefo.tcurso(id_curso)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

ALTER TABLE sigefo.tcurso_planificacion
  ADD CONSTRAINT tcurso_planificacion_fk1 FOREIGN KEY (id_planificacion)
    REFERENCES sigefo.tplanificacion(id_planificacion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;    
/***********************************F-DEP-JUAN-SIGEFO-0-05/05/2017*****************************************/

/***********************************I-DEP-YAC-SIGEFO-1-05/05/2017*****************************************/

ALTER TABLE sigefo.tplanificacion_proveedor
  ADD CONSTRAINT tplanificacion_proveedor_fk FOREIGN KEY (id_planificacion)
REFERENCES sigefo.tplanificacion(id_planificacion)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;
/***********************************F-DEP-YAC-SIGEFO-1-05/05/2017*****************************************/

/***********************************I-DEP-JUAN-SIGEFO-0-08/05/2017*****************************************/


ALTER TABLE sigefo.tcurso_funcionario
  ADD CONSTRAINT tcurso_funcionario_fk FOREIGN KEY (id_curso)
    REFERENCES sigefo.tcurso(id_curso)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE sigefo.tcurso_funcionario
  ADD CONSTRAINT tcurso_funcionario_fk1 FOREIGN KEY (id_funcionario)
    REFERENCES orga.tfuncionario(id_funcionario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
select pxp.f_insert_testructura_gui ('SIGEFOCU', 'SIGEFO');
select pxp.f_delete_testructura_gui ('CUPL', 'SIGEFOCU');
select pxp.f_insert_testructura_gui ('CUPL', 'SIGEFO');
select pxp.f_delete_testructura_gui ('CUFU', 'CUPL');
select pxp.f_insert_testructura_gui ('CUFU', 'SIGEFO');

/***********************************F-DEP-JUAN-SIGEFO-0-08/05/2017*****************************************/

/***********************************I-DEP-JUAN-SIGEFO-0-09/05/2017*****************************************/
ALTER TABLE sigefo.tcurso_competencia
  DROP CONSTRAINT tcurso_competencia_fk RESTRICT;

ALTER TABLE sigefo.tcurso_competencia
  ADD CONSTRAINT tcurso_competencia_fk FOREIGN KEY (id_curso)
    REFERENCES sigefo.tcurso(id_curso)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

ALTER TABLE sigefo.tcurso_planificacion
  DROP CONSTRAINT tcurso_planificacion_fk RESTRICT;

ALTER TABLE sigefo.tcurso_planificacion
  ADD CONSTRAINT tcurso_planificacion_fk FOREIGN KEY (id_curso)
    REFERENCES sigefo.tcurso(id_curso)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
    NOT DEFERRABLE;


ALTER TABLE sigefo.tcurso_funcionario
  DROP CONSTRAINT tcurso_funcionario_fk RESTRICT;

ALTER TABLE sigefo.tcurso_funcionario
  ADD CONSTRAINT tcurso_funcionario_fk FOREIGN KEY (id_curso)
    REFERENCES sigefo.tcurso(id_curso)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

ALTER TABLE sigefo.tplanificacion_competencia
  DROP CONSTRAINT tplanificacion_competencia_fk RESTRICT;

ALTER TABLE sigefo.tplanificacion_competencia
  ADD CONSTRAINT tplanificacion_competencia_fk FOREIGN KEY (id_planificacion)
    REFERENCES sigefo.tplanificacion(id_planificacion)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

ALTER TABLE sigefo.tplanificacion_cargo
  DROP CONSTRAINT tplanificacion_cargo_fk RESTRICT;

ALTER TABLE sigefo.tplanificacion_cargo
  ADD CONSTRAINT tplanificacion_cargo_fk FOREIGN KEY (id_planificacion)
    REFERENCES sigefo.tplanificacion(id_planificacion)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

ALTER TABLE sigefo.tplanificacion_proveedor
  DROP CONSTRAINT tplanificacion_proveedor_fk RESTRICT;

ALTER TABLE sigefo.tplanificacion_proveedor
  ADD CONSTRAINT tplanificacion_proveedor_fk FOREIGN KEY (id_planificacion)
    REFERENCES sigefo.tplanificacion(id_planificacion)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

/***********************************F-DEP-JUAN-SIGEFO-0-09/05/2017*****************************************/

/***********************************I-DEP-YAC-SIGEFO-1-09/05/2017*****************************************/
select pxp.f_insert_testructura_gui ('CUR', 'SIGEFO');
/***********************************F-DEP-YAC-SIGEFO-1-09/05/2017*****************************************/

/***********************************I-DEP-YAC-SIGEFO-0-10/05/2017*****************************************/

ALTER TABLE sigefo.tplanificacion_uo
  ADD CONSTRAINT tplanificacion_uo_fk FOREIGN KEY (id_planificacion)
REFERENCES sigefo.tplanificacion(id_planificacion)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;


ALTER TABLE sigefo.tplanificacion_uo
  ADD CONSTRAINT tplanificacion_uo_fk1 FOREIGN KEY (id_uo)
REFERENCES orga.tuo(id_uo)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;
/***********************************F-DEP-YAC-SIGEFO-0-10/05/2017*****************************************/

/***********************************I-DEP-JUAN-SIGEFO-0-16/05/2017*****************************************/
select pxp.f_insert_testructura_gui ('CACO', 'SIGEFO');
/***********************************F-DEP-JUAN-SIGEFO-0-16/05/2017*****************************************/
/***********************************I-DEP-YAC-SIGEFO-0-17/05/2017*****************************************/

select pxp.f_insert_testructura_gui ('SIGEFOPAR', 'SIGEFO');
select pxp.f_insert_testructura_gui ('SIGEFOCO', 'SIGEFOPAR');
select pxp.f_insert_testructura_gui ('CACO', 'SIGEFOPAR');
/***********************************F-DEP-YAC-SIGEFO-0-17/05/2017*****************************************/


/***********************************I-DEP-JUAN-SIGEFO-0-18/05/2017****************************************/

-- object recreation
ALTER TABLE sigefo.tcurso_planificacion
  DROP CONSTRAINT tcurso_planificacion_fk RESTRICT;

ALTER TABLE sigefo.tcurso_planificacion
  ADD CONSTRAINT tcurso_planificacion_fk FOREIGN KEY (id_curso)
REFERENCES sigefo.tcurso(id_curso)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;


-- object recreation
ALTER TABLE sigefo.tcurso_funcionario
  DROP CONSTRAINT tcurso_funcionario_fk RESTRICT;

ALTER TABLE sigefo.tcurso_funcionario
  ADD CONSTRAINT tcurso_funcionario_fk FOREIGN KEY (id_curso)
REFERENCES sigefo.tcurso(id_curso)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;


-- object recreation
ALTER TABLE sigefo.tcurso_competencia
  DROP CONSTRAINT tcurso_competencia_fk RESTRICT;

ALTER TABLE sigefo.tcurso_competencia
  ADD CONSTRAINT tcurso_competencia_fk FOREIGN KEY (id_curso)
REFERENCES sigefo.tcurso(id_curso)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;


-- object recreation
ALTER TABLE sigefo.tplanificacion_competencia
  DROP CONSTRAINT tplanificacion_competencia_fk RESTRICT;

ALTER TABLE sigefo.tplanificacion_competencia
  ADD CONSTRAINT tplanificacion_competencia_fk FOREIGN KEY (id_planificacion)
REFERENCES sigefo.tplanificacion(id_planificacion)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;


-- object recreation
ALTER TABLE sigefo.tplanificacion_uo
  DROP CONSTRAINT tplanificacion_uo_fk RESTRICT;

ALTER TABLE sigefo.tplanificacion_uo
  ADD CONSTRAINT tplanificacion_uo_fk FOREIGN KEY (id_planificacion)
REFERENCES sigefo.tplanificacion(id_planificacion)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;


-- object recreation
ALTER TABLE sigefo.tplanificacion_cargo
  DROP CONSTRAINT tplanificacion_cargo_fk RESTRICT;

ALTER TABLE sigefo.tplanificacion_cargo
  ADD CONSTRAINT tplanificacion_cargo_fk FOREIGN KEY (id_planificacion)
REFERENCES sigefo.tplanificacion(id_planificacion)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;
/***********************************F-DEP-JUAN-SIGEFO-0-18/05/2017****************************************/



/***********************************I-DEP-MANU-SIGEFO-0-18/06/2017****************************************/
ALTER TABLE sigefo.tavance_real
  ADD CONSTRAINT tavance_real_fk FOREIGN KEY (id_uo)
    REFERENCES orga.tuo(id_uo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
    
ALTER TABLE sigefo.tavance_real
  ADD CONSTRAINT tavance_real_fk1 FOREIGN KEY (id_curso)
    REFERENCES sigefo.tcurso(id_curso)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;    

ALTER TABLE sigefo.tcurso
  ALTER COLUMN nombre_curso TYPE VARCHAR(500) COLLATE pg_catalog."default";

ALTER TABLE sigefo.tcurso
  ADD COLUMN evaluacion VARCHAR(2);

ALTER TABLE sigefo.tcurso
  ADD COLUMN certificacion VARCHAR(2);
/***********************************F-DEP-MANU-SIGEFO-0-18/06/2017****************************************/


/***********************************I-DEP-MANU-SIGEFO-0-20/07/2017****************************************/
select pxp.f_insert_testructura_gui ('SIGEFO', 'SISTEMA');
select pxp.f_insert_testructura_gui ('SIGEFOP', 'SIGEFO');
select pxp.f_delete_testructura_gui ('SIGEFOCO', 'SIGEFO');
select pxp.f_insert_testructura_gui ('SIGEFOCU', 'SIGEFO');
select pxp.f_insert_testructura_gui ('CUPL', 'SIGEFO');
select pxp.f_insert_testructura_gui ('CUFU', 'SIGEFO');
select pxp.f_insert_testructura_gui ('CUR', 'SIGEFO');
select pxp.f_delete_testructura_gui ('CACO', 'SIGEFO');
select pxp.f_insert_testructura_gui ('SIGEFOPAR', 'SIGEFO');
select pxp.f_insert_testructura_gui ('SIGEFOCO', 'SIGEFOPAR');
select pxp.f_insert_testructura_gui ('CACO', 'SIGEFOPAR');
select pxp.f_insert_testructura_gui ('AR', 'SIGEFO');
select pxp.f_delete_testructura_gui ('SIGEFO_CUE', 'SIGEFO');
select pxp.f_delete_testructura_gui ('SIGECO_CAT', 'SIGEFO_CUE');
select pxp.f_delete_testructura_gui ('SIGECOCAT', 'SIGEFO_CUE');
select pxp.f_delete_testructura_gui ('SIGECOCAT', 'CUR');
select pxp.f_delete_testructura_gui ('SIGECOCAT', 'SIGEFOPAR');
select pxp.f_delete_testructura_gui ('SIGECOCAT', 'SIGEFO');
select pxp.f_insert_testructura_gui ('SIGEFOCUE', 'SIGEFO');
select pxp.f_insert_testructura_gui ('SIGECOCAT', 'SIGEFOCUE');
select pxp.f_insert_testructura_gui ('SIGECOPRE', 'SIGEFOCUE');
select pxp.f_insert_testructura_gui ('CUE', 'SIGEFOCUE');

/***********************************F-DEP-MANU-SIGEFO-0-20/07/2017****************************************/


/***********************************I-DEP-MANU-SIGEFO-0-12/09/2017****************************************/
ALTER TABLE sigefo.tcurso
  ADD COLUMN cod_prioridad VARCHAR(10);

/***********************************F-DEP-MANU-SIGEFO-0-12/09/2017****************************************/

/***********************************I-DEP-MANU-SIGEFO-0-13/09/2017****************************************/
ALTER TABLE sigefo.tcurso
  ALTER COLUMN evaluacion TYPE VARCHAR(25) COLLATE pg_catalog."default";

ALTER TABLE sigefo.tcurso
  ALTER COLUMN certificacion TYPE VARCHAR(25) COLLATE pg_catalog."default"; 
/***********************************F-DEP-MANU-SIGEFO-0-13/09/2017****************************************/

/***********************************I-DEP-JUAN-SIGEFO-0-28/09/2017****************************************/
select pxp.f_delete_testructura_gui ('SIGEFOCU', 'SIGEFO');
select pxp.f_delete_testructura_gui ('CUPL', 'SIGEFO');
select pxp.f_delete_testructura_gui ('CUFU', 'SIGEFO');
/***********************************F-DEP-JUAN-SIGEFO-0-28/09/2017****************************************/

/***********************************I-DEP-JUAN-SIGEFO-0-17/11/2017****************************************/ 
select pxp.f_delete_testructura_gui ('SIGEFOCU', 'SIGEFO');
select pxp.f_delete_testructura_gui ('CUPL', 'SIGEFO');
select pxp.f_delete_testructura_gui ('CUFU', 'SIGEFO');
select pxp.f_delete_testructura_gui ('SIGEFOCO', 'SIGEFOPAR');
select pxp.f_delete_testructura_gui ('CACO', 'SIGEFOPAR');
select pxp.f_delete_testructura_gui ('SIGEFOCUE', 'SIGEFO');
select pxp.f_delete_testructura_gui ('SIGECOCAT', 'SIGEFOCUE');
select pxp.f_delete_testructura_gui ('SIGECOPRE', 'SIGEFOCUE');
select pxp.f_delete_testructura_gui ('CUE', 'SIGEFOCUE');
select pxp.f_insert_testructura_gui ('PARCOM', 'SIGEFOPAR');
select pxp.f_insert_testructura_gui ('PAREVAL', 'SIGEFOPAR');
select pxp.f_delete_testructura_gui ('SIGEFOCO', 'PARCOM');
select pxp.f_delete_testructura_gui ('CACO', 'PARCOM');
select pxp.f_delete_testructura_gui ('SIGECOCAT', 'PAREVAL');
select pxp.f_insert_testructura_gui ('SIGECOPRE', 'PAREVAL');
select pxp.f_delete_testructura_gui ('SIGECOCAT', 'SIGECOPRE');
select pxp.f_insert_testructura_gui ('SIGECOCAT', 'PAREVAL');
select pxp.f_insert_testructura_gui ('SIGEFOCO', 'PARCOM');
select pxp.f_insert_testructura_gui ('CACO', 'PARCOM');
select pxp.f_insert_testructura_gui ('CUE', 'SIGEFO');
/***********************************F-DEP-JUAN-SIGEFO-0-17/11/2017****************************************/

/***********************************I-DEP-JUAN-SIGEFO-0-23/11/2017****************************************/ 

ALTER TABLE sigefo.tplanificacion_criterio
  ADD CONSTRAINT tplanificacion_criterio_fk FOREIGN KEY (id_planificacion)
    REFERENCES sigefo.tplanificacion(id_planificacion)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
/***********************************F-DEP-JUAN-SIGEFO-0-23/11/2017****************************************/
