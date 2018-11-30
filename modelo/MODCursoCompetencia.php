<?php
/**
*@package pXP
*@file gen-MODCursoCompetencia.php
*@author  (admin)
*@date 22-01-2017 20:25:54
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCursoCompetencia extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCursoCompetencia(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_curso_competencia_sel';
		$this->transaccion='SIGEFO_CUCO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				 
		//Definicion de la lista del resultado del query
		$this->captura('id_curso_competencia','int4');
		$this->captura('id_curso','int4');
		$this->captura('id_competencia','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		$this->captura('competencia','varchar');
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCursoCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_competencia_ime';
		$this->transaccion='SIGEFO_CUCO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso','id_curso','int4');
		$this->setParametro('id_competencias','id_competencia','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCursoCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_competencia_ime';
		$this->transaccion='SIGEFO_CUCO_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso_competencia','id_curso_competencia','int4');
		$this->setParametro('id_curso','id_curso','int4');
		$this->setParametro('id_competencia','id_competencia','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCursoCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_competencia_ime';
		$this->transaccion='SIGEFO_CUCO_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso_competencia','id_curso_competencia','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>