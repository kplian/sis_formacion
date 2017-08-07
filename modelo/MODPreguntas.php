<?php
/**
*@package pXP
*@file gen-MODPreguntas.php
*@author  (admin)
*@date 20-04-2017 00:51:06
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPreguntas extends MODbase{
	 
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPreguntas(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_preguntas_sel';
		$this->transaccion='SIGEFO_PRE_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				 
		//Definicion de la lista del resultado del query
		$this->captura('id_pregunta','int4');
		$this->captura('id_categoria','int4');
		$this->captura('tipo','varchar');
		$this->captura('pregunta','varchar');
		$this->captura('habilitado','bool');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('categoria','varchar');
		$this->captura('tipocat','varchar');		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

	function listarPreguntasPro(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_preguntas_sel';
		$this->transaccion='SIGEFO_PRE_PRO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_pregunta','int4');
		$this->captura('id_categoria','int4');
		$this->captura('tipo','varchar');
		$this->captura('pregunta','varchar');
		$this->captura('habilitado','bool');
		$this->captura('seccion','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('categoria','varchar');
		$this->captura('tipocat','varchar');		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	
			
	function insertarPreguntas(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_preguntas_ime';
		$this->transaccion='SIGEFO_PRE_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_categoria','id_categoria','int4');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('pregunta','pregunta','varchar');
		$this->setParametro('habilitado','habilitado','bool');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('usuario_ai','usuario_ai','varchar');
		$this->setParametro('fecha_reg','fecha_reg','timestamp');
		$this->setParametro('fecha_mod','fecha_mod','timestamp');
		$this->setParametro('id_usuario_mod','id_usuario_mod','int4');
		$this->setParametro('usr_reg','usr_reg','varchar');
		$this->setParametro('usr_mod','usr_mod','varchar');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPreguntas(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_preguntas_ime';
		$this->transaccion='SIGEFO_PRE_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pregunta','id_pregunta','int4');
		$this->setParametro('id_categoria','id_categoria','int4');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('pregunta','pregunta','varchar');
		$this->setParametro('habilitado','habilitado','bool');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('usuario_ai','usuario_ai','varchar');
		$this->setParametro('fecha_reg','fecha_reg','timestamp');
		$this->setParametro('fecha_mod','fecha_mod','timestamp');
		$this->setParametro('id_usuario_mod','id_usuario_mod','int4');
		$this->setParametro('usr_reg','usr_reg','varchar');
		$this->setParametro('usr_mod','usr_mod','varchar');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPreguntas(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_preguntas_ime';
		$this->transaccion='SIGEFO_PRE_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_pregunta','id_pregunta','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	
	function insertarPreguntasPro(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_preguntas_ime';
		$this->transaccion='SIGEFO_PRE_PRO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function insertarPreguntasFun(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_preguntas_ime';
		$this->transaccion='SIGEFO_PRE_FUN_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>