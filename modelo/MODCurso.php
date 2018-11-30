<?php
/**
*@package pXP
*@file gen-MODCurso.php
*@author  (admin)
*@date 22-01-2017 15:35:03
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCurso extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
	
	function listarCurso(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_curso_sel';
		$this->transaccion='SIGEFO_SCU_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		//Definicion de la lista del resultado del query
		$this->captura('id_curso','int4');
		$this->captura('id_gestion','int4');
		$this->captura('id_lugar','int4');
		$this->captura('id_lugar_pais','int4');
		$this->captura('id_proveedor','int4');
		$this->captura('origen','varchar');
		$this->captura('fecha_inicio','date');
		$this->captura('objetivo','varchar');
		$this->captura('estado_reg','varchar');
		
		$this->captura('cod_tipo','varchar');
		$this->captura('cod_prioridad','varchar');
		
		$this->captura('horas','numeric');
		$this->captura('nombre_curso','varchar');
		$this->captura('cod_clasificacion','varchar');
		$this->captura('expositor','varchar');
		$this->captura('contenido','varchar');
		$this->captura('fecha_fin','date');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');

		$this->captura('evaluacion','varchar');
		$this->captura('certificacion','varchar');
		
		$this->captura('gestion','int4');
		$this->captura('nombre_pais','varchar');
		$this->captura('nombre','varchar');
		$this->captura('desc_proveedor','varchar');
		
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		$this->captura('id_competencias','varchar');
		$this->captura('desc_competencia','varchar');
		
	    $this->captura('id_planificacion','int4');
		$this->captura('planificacion','varchar');
		
	    $this->captura('id_funcionarios','varchar');
		$this->captura('funcionarios','varchar');
		
		$this->captura('id_uo','int4');
        $this->captura('desc_uo','varchar');
		$this->captura('id_unidad_organizacional','int4');
		$this->captura('unidad_organizacional','varchar');
		$this->captura('peso','numeric');
        $this->captura('cantidad_personas','int4');
		$this->captura('comite_etica','varchar');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	function listarCursoEvaluacion(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_curso_sel';
		$this->transaccion='SIGEFO_CURCUEST_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		
		$this->setParametro('id_usuario', 'id_usuario','int4');
		//Definicion de la lista del resultado del query
		$this->captura('id_curso','int4');
		$this->captura('id_gestion','int4');
		$this->captura('id_lugar','int4');
		$this->captura('id_lugar_pais','int4');
		$this->captura('id_proveedor','int4');
		$this->captura('origen','varchar');
		$this->captura('fecha_inicio','date');
		$this->captura('objetivo','varchar');
		$this->captura('estado_reg','varchar');
		
		$this->captura('cod_tipo','varchar');
		$this->captura('cod_prioridad','varchar');
		
		$this->captura('horas','numeric');
		$this->captura('nombre_curso','varchar');
		$this->captura('cod_clasificacion','varchar');
		$this->captura('expositor','varchar');
		$this->captura('contenido','varchar');
		$this->captura('fecha_fin','date');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');

		$this->captura('evaluacion','varchar');
		$this->captura('certificacion','varchar');
		
		$this->captura('gestion','int4');
		$this->captura('nombre_pais','varchar');
		$this->captura('nombre','varchar');
		$this->captura('desc_proveedor','varchar');
		
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		$this->captura('id_competencias','varchar');
		$this->captura('desc_competencia','varchar');
		
	    $this->captura('id_planificacion','int4');
		$this->captura('planificacion','varchar');
		
	    $this->captura('id_funcionarios','varchar');
		$this->captura('funcionarios','varchar');
		
		$this->captura('id_uo','int4');
        $this->captura('desc_uo','varchar');
		$this->captura('id_unidad_organizacional','int4');
		$this->captura('unidad_organizacional','varchar');
		$this->captura('peso','numeric');
        $this->captura('cantidad_personas','int4');
		$this->captura('funcionario_eval','varchar');
		$this->captura('id_funcionario','int4');
		$this->captura('usuario','varchar');
		
		$this->captura('id_usuario','int4');
		$this->captura('funcionario','varchar');
		$this->captura('id_curso_funcionario','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

			
	function insertarCurso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_ime';
		$this->transaccion='SIGEFO_SCU_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('id_lugar_pais','id_lugar_pais','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('origen','origen','varchar');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('objetivo','objetivo','varchar');
		
		//$this->setParametro('estado_reg','estado_reg','varchar');
		
		$this->setParametro('cod_tipo','cod_tipo','varchar');
		$this->setParametro('cod_prioridad','cod_prioridad','varchar');
		
		$this->setParametro('horas','horas','numeric');
		$this->setParametro('nombre_curso','nombre_curso','varchar');
		$this->setParametro('cod_clasificacion','cod_clasificacion','varchar');
		$this->setParametro('expositor','expositor','varchar');
		$this->setParametro('contenido','contenido','varchar');
		$this->setParametro('fecha_fin','fecha_fin','date');
		
		$this->setParametro('id_competencias','id_competencias','varchar');
	    $this->setParametro('id_funcionarios','id_funcionarios','varchar');
		$this->setParametro('id_planificacion','id_planificacion','int4');	
		
		$this->setParametro('evaluacion','evaluacion','varchar');	
		$this->setParametro('certificacion','certificacion','varchar');	

	
        $this->setParametro('id_uo','id_uo','varchar');	
		$this->setParametro('id_unidad_organizacional','id_unidad_organizacional','int4');	
        $this->setParametro('comite_etica','comite_etica','varchar');	
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCurso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_ime';
		$this->transaccion='SIGEFO_SCU_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso','id_curso','int4');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('id_lugar_pais','id_lugar_pais','int4');
		$this->setParametro('id_proveedor','id_proveedor','int4');
		$this->setParametro('origen','origen','varchar');
		$this->setParametro('fecha_inicio','fecha_inicio','date');
		$this->setParametro('objetivo','objetivo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('cod_tipo','cod_tipo','varchar');
		$this->setParametro('cod_prioridad','cod_prioridad','varchar');
		$this->setParametro('horas','horas','numeric');
		$this->setParametro('nombre_curso','nombre_curso','varchar');
		$this->setParametro('cod_clasificacion','cod_clasificacion','varchar');
		$this->setParametro('expositor','expositor','varchar');
		$this->setParametro('contenido','contenido','varchar');
		$this->setParametro('fecha_fin','fecha_fin','date');
		
		$this->setParametro('id_competencias','id_competencias','varchar');
	    $this->setParametro('id_funcionarios','id_funcionarios','varchar');
		$this->setParametro('id_planificacion','id_planificacion','int4');		
		$this->setParametro('evaluacion','evaluacion','varchar');	
		$this->setParametro('certificacion','certificacion','varchar');		
		
        $this->setParametro('id_uo','id_uo','varchar');	
		$this->setParametro('id_unidad_organizacional','id_unidad_organizacional','int4');		
		$this->setParametro('comite_etica','comite_etica','varchar');	
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCurso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_ime';
		$this->transaccion='SIGEFO_SCU_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso','id_curso','int4');
		//$this->setParametro('id_gestion','id_gestion','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function listarPaisLugar(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sigefo.ft_curso_sel';
        $this->transaccion='PM_PAISLUGAR_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_lugar','int4');
        $this->captura('nombre','varchar');
        $this->captura('tipo','varchar');

        //$this->captura('nombre_lugar','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarCursoAvanceArb(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sigefo.ft_curso_sel';		
 		$this->setCount(false);	
        $this->transaccion='SIGEFO_SCU_ARB_SEL';		
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $id_padre = $this->objParam->getParametro('id_padre');
        $this->setParametro('id_padre', 'id_padre', 'varchar');	        
		$this->setParametro('id_gestion', 'id_gestion', 'int4');
		
        //Definicion de la lista del resultado del query
        $this->captura('id_correlativo','int4');
		$this->captura('id_uo_t_temp','int4');
        $this->captura('id_uo_padre_temp','int4');
        $this->captura('id_uo_temp','int4');
        $this->captura('nombre_unidad_temp','varchar');
		$this->captura('id_curso_temp','int4');
        $this->captura('nombre_curso_temp','varchar');
		$this->captura('cod_prioridad_temp','varchar');
        $this->captura('tipo_nodo_temp','varchar');
		
		$this->captura('id_correlativo_key','int4');
		$this->captura('horas_temp','varchar');		
		$this->captura('cantidad_temp','varchar');
		$this->captura('prioridad_temp','varchar');
		$this->captura('tparcial_temp','varchar');
		$this->captura('peso_temp','numeric');	 
        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }	
	
	function listarCursoAvanceDinamico(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sigefo.ft_curso_sel';		
        $this->transaccion='SIGEFO_LCURSO_SEL';		
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        $this->setParametro('id_gestion', 'id_gestion', 'int4'); 
		 
		 
		$this->captura('id_temporal','int4');  //este id no se esta usando solo para cumplir las reglas de framework ya que este viene de una tabla temporal
		$this->captura('id_curso','int4');
		$this->captura('nombre_curso','varchar');
        $this->captura('id_gestion','int4');	
        $this->captura('cod_prioridad','varchar');
		$this->captura('horas','int4');
		$this->captura('peso','numeric');	
			
        //Calculamos las columnas dinamicas de meses
        $datos = $this->objParam->getParametro('datos');
		$arrayMeses= explode('@',$datos);
		$tamaño = sizeof($arrayMeses);
		for($i=1;$i<$tamaño;$i++){
		
			$this->captura($arrayMeses[$i],'varchar');
			
			if($i!=$tamaño-1){
			   $this->captura('id_lavance'.$i.'','int4');
		    }
		}
		//

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();
        //Devuelve la respuesta
        return $this->respuesta;
    }
	
	function GenerarColumnaMeses(){
		$this->procedimiento='sigefo.ft_curso_ime';
		$this->transaccion='SIGEFO_CANT_MES';		
		$this->tipo_procedimiento='IME';
	
		$this->setParametro('id_gestion','id_gestion','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		//Devuelve la respuesta
		return $this->respuesta;
	}	
	
	function insertarAvanceReal(){
		
		$this->procedimiento='sigefo.ft_curso_ime';
		$this->transaccion='SIGEFO_CUR_AREAL_MOD';
		$this->tipo_procedimiento='IME';			

        $datos = $this->objParam->getParametro('datos');
		
		$this->setParametro('id_curso','id_curso','int4');
		$this->setParametro('nombre_curso','nombre_curso','varchar');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('cod_prioridad','cod_prioridad','varchar');
		$this->setParametro('horas','horas','int4');
        $this->setParametro('peso','peso','numeric');
		$aux = $this->objParam->getParametro(0);
		$datos = $aux['datos'];
		
		$arrayMeses= explode('@',$datos);
		$tamaño = sizeof($arrayMeses);
		
		for($i=1;$i<$tamaño;$i++){			
			$this->setParametro($arrayMeses[$i],$arrayMeses[$i],'varchar');
			if($i!=$tamaño-1){
			   $this->captura('id_lavance'.$i.'','int4');
			   $this->setParametro('id_lavance'.$i,'id_lavance'.$i,'int4');
		    }
		}

		$this->armarConsulta();
		$this->ejecutarConsulta();

		return $this->respuesta;
	}
    function datosPlanificacion()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento='sigefo.ft_curso_ime';
        $this->transaccion = 'DAT_PLANIFICA';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_planificacion', 'id_planificacion', 'int4');
		//$this->setParametro('estado', 'estado', 'bool');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function listarProveedorCombos(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_curso_sel';	
		$this->transaccion='SIGEFO_PROV_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->setParametro('id_lugar','id_lugar','int4');
	
        $this->captura('id_proveedor','INTEGER');
		$this->captura('id_persona','INTEGER');
		$this->captura('codigo','VARCHAR');
		$this->captura('numero_sigma','VARCHAR');
		$this->captura('tipo','VARCHAR');
		$this->captura('id_institucion','INTEGER');
		$this->captura('desc_proveedor','VARCHAR');
		$this->captura('nit','VARCHAR');
		$this->captura('id_lugar','int4');
		$this->captura('lugar','varchar');
		$this->captura('pais','varchar');
		$this->captura('rotulo_comercial','varchar');
		$this->captura('email','varchar');
		$this->captura('cod_proveedor','int4');

	
		//Ejecuta la instruccion
		$this->armarConsulta();
		//echo $this->consulta; exit;
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	 }
     function listarFuncionarioCombos(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_curso_sel';	
		$this->transaccion='PM_FUNCIO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
	
        $this->captura('id_funcionario','int4');
		$this->captura('codigo','varchar');
		$this->captura('desc_person','varchar');
		$this->captura('ci','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		//echo $this->consulta; exit;
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	 }
	/*function datosPlanificacion(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_curso_sel';
		$this->transaccion='DAT_PLANIFICA_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		$this->setParametro('id_planificacion', 'id_planificacion', 'int4');
		 
		$this->captura('id_unidad_organizacional','int4');
		$this->captura('id_gerencia','int4');

		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}*/
	function listarPreguntas(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_curso_sel';
		$this->transaccion='CUESTIONARIO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		
		
		$this->setParametro('tipo', 'tipo', 'varchar');
		$this->setParametro('id_curso', 'id_curso', 'int4');
		$this->setParametro('id_usuario', 'id_usuario', 'int4');
		$this->setParametro('id_proveedor', 'id_proveedor', 'int4');
		$this->setParametro('tipo_cuestionario', 'tipo_cuestionario', 'varchar');
		
		//Definicion de la lista del resultado del query
		$this->captura('id_temporal','int4');
		$this->captura('id_pregunta','int4');
		$this->captura('pregunta','varchar');
		$this->captura('respuesta','varchar');
		$this->captura('tipo','varchar');
		$this->captura('nivel','varchar');
		$this->captura('id_usuario_reg','int4');
        $this->captura('id_curso','int4');
		$this->captura('id_usuario','int4');
		$this->captura('tipo_cuestionario','varchar');
		//$this->captura('id_proveedor','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	function insertarCuestionario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_ime';
		$this->transaccion='CUESTIO_INS';
		$this->tipo_procedimiento='IME';
				

        $this->setParametro('tipo_cuestionario', 'tipo_cuestionario', 'varchar');
		$this->setParametro('id_proveedor', 'id_proveedor', 'int4');
		
		$this->setParametro('id_usuario', 'id_usuario', 'int4');
		$this->setParametro('id_curso', 'id_curso', 'int4');
		
		$this->setParametro('id_temporal','id_temporal','int4');
		$this->setParametro('id_pregunta','id_pregunta','int4');
		
		$this->setParametro('pregunta','pregunta','varchar');
		$this->setParametro('respuesta','respuesta','varchar');
		$this->setParametro('tipo','tipo','varchar');
		
		$this->setParametro('nivel','nivel','varchar');
		$this->setParametro('id_usuario_reg','id_usuario_reg','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	function listarPreguntasProveedor(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_curso_sel';
		$this->transaccion='CUEST_PROV_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		
		
		$this->setParametro('tipo', 'tipo', 'varchar');
		$this->setParametro('id_curso', 'id_curso', 'int4');
		$this->setParametro('id_proveedor', 'id_proveedor', 'int4');
		
		//Definicion de la lista del resultado del query
		$this->captura('id_temporal','int4');
		$this->captura('id_pregunta','int4');
		$this->captura('pregunta','varchar');
		$this->captura('respuesta','varchar');
		$this->captura('tipo','varchar');
		$this->captura('nivel','varchar');
		$this->captura('id_usuario_reg','int4');
        $this->captura('id_curso','int4');
		$this->captura('id_proveedor','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	////////////EGS- 08/08/2018/////////////////
	function envioCorreo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_enviocorreo_sel';
		$this->transaccion='SIGEFO_ENCO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false); 
		
		//$this->setParametro('id_curso', 'id_curso', 'int4');
		$this->setParametro('id_curso','id_curso','json_text');
		$this->setParametro('usuario_envio','usuario_envio','varchar');
		
		//var_dump($this->objParam);
		//Definicion de la lista del resultado del query
		
		$this->captura('id_curso_funcionario','int4');
		$this->captura('id_curso','int4');
		$this->captura('id_funcionario','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_person','text');
		$this->captura('codigo','varchar');
		$this->captura('id_usuario','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	////////////EGS-08/08/2018/////////////////
	
}
?>