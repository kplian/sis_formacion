<?php
/**
*@package pXP
*@file gen-MODCursoFuncionario.php
*@author  (admin)
*@date 26-01-2017 16:26:09
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
	issue			fecha				autor					descripcion
 * #1				01/11/2018			EGS						se aumento campos para saber si o no se respondio el cuestionario de evaluacion del curso segun el curso y funcionario especificado
 * 
 * */

class MODCursoFuncionario extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
		 	
	function listarCursoFuncionario(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_curso_funcionario_sel';
		$this->transaccion='SIGEFO_CUFU_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
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
		
		$this->captura('nro_respuesta','integer');//#1				01/11/2018			EGS	
		$this->captura('evaluo','varchar');//#1				01/11/2018			EGS	
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCursoFuncionario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_funcionario_ime';
		$this->transaccion='SIGEFO_CUFU_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso','id_curso','int4');
		$this->setParametro('id_funcionarios','id_funcionarios','varchar');
		//$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCursoFuncionario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_funcionario_ime';
		$this->transaccion='SIGEFO_CUFU_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso_funcionario','id_curso_funcionario','int4');
		$this->setParametro('id_curso','id_curso','int4');
		$this->setParametro('id_funcionario','id_funcionario','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCursoFuncionario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_funcionario_ime';
		$this->transaccion='SIGEFO_CUFU_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso_funcionario','id_curso_funcionario','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	function limpiarCuestionario(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_funcionario_ime';
		$this->transaccion='SIGEFO_CFU_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso','id_curso','int4');
	    $this->setParametro('id_funcionario','id_funcionario','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	function limpiarCuestionarioProveedor(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_curso_funcionario_ime';
		$this->transaccion='SIGEFO_CFUPROV_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_curso','id_curso','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>