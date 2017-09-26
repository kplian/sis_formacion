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
		
		$this->captura('horas','int4');
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
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		$this->captura('gestion','int4');
		$this->captura('nombre','varchar');
		$this->captura('nombre_pais','varchar');
		$this->captura('desc_proveedor','varchar');
		$this->captura('evaluacion','varchar');
		$this->captura('certificacion','varchar');
		$this->captura('id_competencias','varchar');
		$this->captura('competencias','varchar');
		
	    $this->captura('id_planificaciones','varchar');
		$this->captura('planificaciones','varchar');
		
	    $this->captura('id_funcionarios','varchar');
		$this->captura('funcionarios','varchar');
		
		
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
		
		$this->setParametro('horas','horas','int4');
		$this->setParametro('nombre_curso','nombre_curso','varchar');
		$this->setParametro('cod_clasificacion','cod_clasificacion','varchar');
		$this->setParametro('expositor','expositor','varchar');
		$this->setParametro('contenido','contenido','varchar');
		$this->setParametro('fecha_fin','fecha_fin','date');
		
		$this->setParametro('id_competencias','id_competencias','varchar');
	    $this->setParametro('id_funcionarios','id_funcionarios','varchar');
		$this->setParametro('id_planificaciones','id_planificaciones','varchar');	
		
		$this->setParametro('evaluacion','evaluacion','varchar');	
		$this->setParametro('certificacion','certificacion','varchar');				

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
		$this->setParametro('horas','horas','int4');
		$this->setParametro('nombre_curso','nombre_curso','varchar');
		$this->setParametro('cod_clasificacion','cod_clasificacion','varchar');
		$this->setParametro('expositor','expositor','varchar');
		$this->setParametro('contenido','contenido','varchar');
		$this->setParametro('fecha_fin','fecha_fin','date');
		
		$this->setParametro('id_competencias','id_competencias','varchar');
	    $this->setParametro('id_funcionarios','id_funcionarios','varchar');
		$this->setParametro('id_planificaciones','id_planificaciones','varchar');		
		$this->setParametro('evaluacion','evaluacion','varchar');	
		$this->setParametro('certificacion','certificacion','varchar');		
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
		$this->captura('peso_temp','numeric');	
			
		$aux = $this->objParam->getParametro(0);
		$datos = $aux['datos'];		
		$arrayMeses= explode('@',$datos);
		$tamaño = sizeof($arrayMeses);		
		for($i=1;$i<$tamaño;$i++){			
			$this->setParametro($arrayMeses[$i],$arrayMeses[$i],'varchar');
		}			
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
		//Define los parametros para la funcion
        $datos = $this->objParam->getParametro('datos');
		
		$this->setParametro('id_correlativo','id_correlativo','int4');
		$this->setParametro('nombre_unidad_temp','nombre_unidad_temp','varchar');
		$this->setParametro('nombre_curso_temp','nombre_curso_temp','varchar');
		$this->setParametro('cod_prioridad_temp','cod_prioridad_temp','varchar');
		$this->setParametro('tipo_nodo_temp','tipo_nodo_temp','varchar');
        $this->setParametro('id_correlativo_key','id_correlativo_key','int4');
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
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		//Devuelve la respuesta
		return $this->respuesta;
	}
	
}
?>