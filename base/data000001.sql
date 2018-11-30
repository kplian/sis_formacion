/********************************************I-DAT-YAC-SIGEFO-0-15/01/2013********************************************/

INSERT INTO segu.tsubsistema ("codigo", "nombre", "fecha_reg", "prefijo", "estado_reg", "nombre_carpeta", "id_subsis_orig")
VALUES   ( E'SIGEFO', E'Sistema de gestión de la formación', E'2017-04-26', E'SIGEFO', E'activo', E'formacion', NULL);

select pxp.f_insert_tgui ('SISTEMA DE GESTIÓN DE LA FORMACIÓN', '', 'SIGEFO', 'si', 1, '', 1, '', '', 'SIGEFO');

/********************************************F-DAT-YAC-SIGEFO-0-15/01/2013********************************************/
/********************************************I-DAT-YAC-SIGEFO-0-05/05/2017********************************************/
select pxp.f_insert_tgui ('Planificación', 'Planificación', 'SIGEFOP', 'si', 1, 'sis_formacion/vista/planificacion/Planificacion.php', 2, '', 'Planificacion', 'SIGEFO');
select pxp.f_insert_tgui ('Competencias', 'Competencias', 'SIGEFOCO', 'si', 2, 'sis_formacion/vista/competencia/Competencia.php', 2, '', 'Competencia', 'SIGEFO');

/********************************************F-DAT-YAC-SIGEFO-0-05/05/2017********************************************/

/********************************************I-DAT-YAC-SIGEFO-1-05/05/2017********************************************/

select param.f_import_tcatalogo_tipo ('insert','tplanificacion_critico','SIGEFO','tplanificacion_critico');
select param.f_import_tcatalogo ('insert','SIGEFO','criterio 01','cri01','tplanificacion_critico');
select param.f_import_tcatalogo ('insert','SIGEFO','criterio 02','cri02','tplanificacion_critico');

select param.f_import_tcatalogo_tipo ('insert','tipocompetencia','SIGEFO','tcompetencia');
select param.f_import_tcatalogo ('insert','SIGEFO','Conocimiento','conocimiento','tipocompetencia');
select param.f_import_tcatalogo ('insert','SIGEFO','Cualidad','cualidad','tipocompetencia');
select param.f_import_tcatalogo ('insert','SIGEFO','Actitud','actitud','tipocompetencia');

/********************************************F-DAT-YAC-SIGEFO-1-05/05/2017********************************************/
 
/********************************************I-DAT-JUAN-SIGEFO-1-08/05/2017********************************************/

select pxp.f_insert_tgui ('Curso competencia', 'Cursos', 'SIGEFOCU', 'no', 3, 'sis_formacion/vista/curso/FormCursoCompetencia.php', 2, '', 'FormCursoCompetencia', 'SIGEFO');
select pxp.f_insert_tgui ('Curso planificación', 'Curso planificación', 'CUPL', 'no', 4, 'sis_formacion/vista/curso/FormCursoPlanificacion.php', 3, '', 'FormCursoPlanificacion', 'SIGEFO');
select pxp.f_insert_tgui ('Curso funcionario', 'Curso funcionario', 'CUFU', 'no', 5, 'sis_formacion/vista/curso/FormCursoFuncionario.php', 4, '', 'FormCursoFuncionario', 'SIGEFO');

select pxp.f_insert_tgui ('Curso', 'Curso', 'CUR', 'si', 5, 'sis_formacion/vista/curso/Curso.php', 2, '', 'Curso', 'SIGEFO');

select param.f_import_tcatalogo_tipo ('insert','tipo_curso','SIGEFO','tcurso');
select param.f_import_tcatalogo ('insert','SIGEFO','Seminario','tc_seminario','tipo_curso');
select param.f_import_tcatalogo ('insert','SIGEFO','Curso','tc_curso','tipo_curso');


select param.f_import_tcatalogo_tipo ('insert','clasificacion_curso','SIGEFO','tcurso');
select param.f_import_tcatalogo ('insert','SIGEFO','Formación','cc_formacion','clasificacion_curso');
select param.f_import_tcatalogo ('insert','SIGEFO','Capacitación','cc_capacitacion','clasificacion_curso');
select param.f_import_tcatalogo ('insert','SIGEFO','Entrenamiento','cc_entrenamiento','clasificacion_curso');


select param.f_import_tcatalogo_tipo ('insert','origen_curso','SIGEFO','tcurso');
select param.f_import_tcatalogo ('insert','SIGEFO','Externo','oc_externo','origen_curso');
select param.f_import_tcatalogo ('insert','SIGEFO','Interno','oc_interno','origen_curso');

/********************************************F-DAT-JUAN-SIGEFO-1-08/05/2017********************************************/

/********************************************I-DAT-JUAN-SIGEFO-1-16/05/2017********************************************/
select pxp.f_insert_tgui ('SISTEMA DE GESTIÓN DE LA FORMACIÓN', '', 'SIGEFO', 'si', 1, '', 1, '', '', 'SIGEFO');
select pxp.f_insert_tgui ('Cargo competencia', 'Cargo competencia', 'CACO', 'si', 6, 'sis_formacion/vista/competencia/FormCargo.php', 2, '', 'FormCargo', 'SIGEFO');
/********************************************F-DAT-JUAN-SIGEFO-1-16/05/2017********************************************/
/********************************************I-DAT-YAC-SIGEFO-0-17/05/2017********************************************/
select pxp.f_insert_tgui ('Competencias', 'Competencias', 'SIGEFOCO', 'si', 1, 'sis_formacion/vista/competencia/Competencia.php', 2, '', 'Competencia', 'SIGEFO');
select pxp.f_insert_tgui ('Cargo competencia', 'Cargo competencia', 'CACO', 'si', 2, 'sis_formacion/vista/competencia/FormCargo.php', 2, '', 'FormCargo', 'SIGEFO');
select pxp.f_insert_tgui ('Parametrización', 'Parametrización de los datos', 'SIGEFOPAR', 'si', 1, '', 2, '', '', 'SIGEFO');
/********************************************F-DAT-YAC-SIGEFO-0-17/05/2017********************************************/


/********************************************I-DAT-MANU-SIGEFO-0-20/07/2017********************************************/
select pxp.f_insert_tgui ('SISTEMA DE GESTIÓN DE COMPETENCIAS', '', 'SIGEFO', 'si', 1, '', 1, '', '', 'SIGEFO');
select pxp.f_insert_tgui ('Planificación', 'Planificación', 'SIGEFOP', 'si', 1, 'sis_formacion/vista/planificacion/Planificacion.php', 2, '', 'Planificacion', 'SIGEFO');
select pxp.f_insert_tgui ('Competencias', 'Competencias', 'SIGEFOCO', 'si', 1, 'sis_formacion/vista/competencia/Competencia.php', 2, '', 'Competencia', 'SIGEFO');
select pxp.f_insert_tgui ('Curso competencia', 'Cursos', 'SIGEFOCU', 'no', 3, 'sis_formacion/vista/curso/FormCursoCompetencia.php', 2, '', 'FormCursoCompetencia', 'SIGEFO');
select pxp.f_insert_tgui ('Curso planificación', 'Curso planificación', 'CUPL', 'no', 4, 'sis_formacion/vista/curso/FormCursoPlanificacion.php', 3, '', 'FormCursoPlanificacion', 'SIGEFO');
select pxp.f_insert_tgui ('Curso funcionario', 'Curso funcionario', 'CUFU', 'no', 5, 'sis_formacion/vista/curso/FormCursoFuncionario.php', 4, '', 'FormCursoFuncionario', 'SIGEFO');
select pxp.f_insert_tgui ('Curso', 'Curso', 'CUR', 'si', 5, 'sis_formacion/vista/curso/Curso.php', 2, '', 'Curso', 'SIGEFO');
select pxp.f_insert_tgui ('Cargo competencia', 'Cargo competencia', 'CACO', 'si', 2, 'sis_formacion/vista/competencia/FormCargo.php', 2, '', 'FormCargo', 'SIGEFO');
select pxp.f_insert_tgui ('Parametrización', 'Parametrización de los datos', 'SIGEFOPAR', 'si', 1, '', 2, '', '', 'SIGEFO');
select pxp.f_insert_tgui ('Avance Real', 'Avance Real', 'AR', 'si', 8, 'sis_formacion/vista/curso/FormCursoAvanceReal.php', 2, '', 'FormCursoAvanceReal', 'SIGEFO');
select pxp.f_delete_tgui ('SIGEFO_CUE');
select pxp.f_delete_tgui ('SIGECO_CAT');
select pxp.f_insert_tgui ('Categoria', 'Categoria', 'SIGECOCAT', 'si', 11, 'sis_formacion/vista/categoria/Categoria.php', 3, '', 'Categoria', 'SIGEFO');
select pxp.f_insert_tgui ('Cuestionario', 'Cuestionario', 'SIGEFOCUE', 'si', 9, '', 2, '', '', 'SIGEFO');
select pxp.f_insert_tgui ('Preguntas', 'Preguntas', 'SIGECOPRE', 'si', 12, 'sis_formacion/vista/preguntas/Preguntas.php', 3, '', 'Preguntas', 'SIGEFO');
select pxp.f_insert_tgui ('Cuestionario', 'Cuestionario', 'CUE', 'si', 13, 'sis_formacion/vista/preguntas/Generador.php', 3, '', 'Generador', 'SIGEFO');

/********************************************F-DAT-MANU-SIGEFO-0-20/07/2017********************************************/

/********************************************I-DAT-MANU-SIGEFO-0-12/09/2017********************************************/
select pxp.f_insert_tgui ('Curso', 'Curso', 'CUR', 'si', 5, 'sis_formacion/vista/curso/Curso.php', 2, '', 'Curso', 'SIGEFO');
/********************************************F-DAT-MANU-SIGEFO-0-12/09/2017********************************************/


/********************************************I-DAT-JUAN-SIGEFO-1-28/09/2017********************************************/
select pxp.f_insert_tgui ('Planificación', 'Planificación', 'SIGEFOP', 'si', 2, 'sis_formacion/vista/planificacion/Planificacion.php', 2, '', 'Planificacion', 'SIGEFO');
select pxp.f_delete_tgui ('SIGEFOCU');
select pxp.f_delete_tgui ('CUPL');
select pxp.f_delete_tgui ('CUFU');
select pxp.f_insert_tgui ('Curso', 'Curso', 'CUR', 'si', 3, 'sis_formacion/vista/curso/Curso.php', 2, '', 'Curso', 'SIGEFO');
select pxp.f_insert_tgui ('Avance Real', 'Avance Real', 'AR', 'si', 4, 'sis_formacion/vista/curso/FormCursoAvanceReal.php', 2, '', 'FormCursoAvanceReal', 'SIGEFO');
select pxp.f_insert_tgui ('Cuestionario', 'Cuestionario', 'SIGEFOCUE', 'si', 5, '', 2, '', '', 'SIGEFO');
/********************************************F-DAT-JUAN-SIGEFO-1-28/09/2017********************************************/

/********************************************I-DAT-JUAN-SIGEFO-1-17/11/2017********************************************/
select pxp.f_insert_tgui ('Planificación', 'Planificación', 'SIGEFOP', 'si', 2, 'sis_formacion/vista/planificacion/Planificacion.php', 2, '', 'Planificacion', 'SIGEFO');
select pxp.f_insert_tgui ('Competencias', 'Competencias', 'SIGEFOCO', 'si', 3, 'sis_formacion/vista/competencia/Competencia.php', 2, '', 'Competencia', 'SIGEFO');
select pxp.f_delete_tgui ('SIGEFOCU');
select pxp.f_delete_tgui ('CUPL');
select pxp.f_delete_tgui ('CUFU');
select pxp.f_insert_tgui ('Curso', 'Curso', 'CUR', 'si', 3, 'sis_formacion/vista/curso/Curso.php', 2, '', 'Curso', 'SIGEFO');
select pxp.f_insert_tgui ('Cargo competencia', 'Cargo competencia', 'CACO', 'si', 4, 'sis_formacion/vista/competencia/FormCargo.php', 2, '', 'FormCargo', 'SIGEFO');
select pxp.f_insert_tgui ('Avance Real', 'Avance Real', 'AR', 'si', 4, 'sis_formacion/vista/curso/FormCursoAvanceReal.php', 2, '', 'FormCursoAvanceReal', 'SIGEFO');
select pxp.f_insert_tgui ('Categoria', 'Categoria', 'SIGECOCAT', 'si', 1, 'sis_formacion/vista/categoria/Categoria.php', 3, '', 'Categoria', 'SIGEFO');
select pxp.f_delete_tgui ('SIGEFOCUE');
select pxp.f_insert_tgui ('Preguntas', 'Preguntas', 'SIGECOPRE', 'si', 2, 'sis_formacion/vista/preguntas/Preguntas.php', 3, '', 'Preguntas', 'SIGEFO');
select pxp.f_insert_tgui ('Evaluación de curso', 'Evaluación de curso', 'CUE', 'si', 6, 'sis_formacion/vista/preguntas/Generador.php', 3, '', 'Generador', 'SIGEFO');
select pxp.f_insert_tgui ('Competencia', 'Lista de parametrizacion de competencia', 'PARCOM', 'si', 1, '', 3, '', '', 'SIGEFO');
select pxp.f_insert_tgui ('Evaluación', 'Parametrizacion de evaluacion', 'PAREVAL', 'si', 2, '', 3, '', '', 'SIGEFO');
/********************************************F-DAT-JUAN-SIGEFO-1-17/11/2017********************************************/
