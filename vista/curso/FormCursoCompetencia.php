<?php
/**
 * @package pXP
 * @file gen-SistemaDist.php
 * @author  (rarteaga)
 * @date 20-09-2011 10:22:05
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormCursoCompetencia = {
        //bsave: false,
        require: '../../../sis_formacion/vista/curso/Curso.php',
        requireclase: 'Phx.vista.Curso',
        title: 'Curso',

        constructor: function (config) {
            this.maestro = config.maestro;
            Phx.vista.FormCursoCompetencia.superclass.constructor.call(this, config);
            this.init();
           // this.bloquearMenus();
           
           //alert("hola");
        },
        
	tabeast: [
            {
                url: '../../../sis_formacion/vista/curso_competencia/CursoCompetencia.php',
                title: 'Curso competencias',
                width: 500,
                cls: 'CursoCompetencia'
            }
     ],
              
        
    };
</script>
