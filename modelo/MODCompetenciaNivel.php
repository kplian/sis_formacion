<?php
/**
*@package pXP
*@file gen-MODCompetenciaNivel.php
*@author  (jjimenez)
*@date 11-06-2018 20:42:44
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCompetenciaNivel extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCompetenciaNivel(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_competencia_nivel_sel';
		$this->transaccion='SIGEFO_COMNIV_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		$this->setParametro('id_competencia','id_competencia','int4');
		//Definicion de la lista del resultado del query
		$this->captura('id_competencia_nivel','int4');
		$this->captura('nivel','varchar');
		$this->captura('id_competencia','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('descripcion','varchar');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCompetenciaNivel(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_competencia_nivel_ime';
		$this->transaccion='SIGEFO_COMNIV_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('nivel','nivel','varchar');
		$this->setParametro('id_competencia','id_competencia','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
        $this->setParametro('descripcion','descripcion','varchar');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCompetenciaNivel(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_competencia_nivel_ime';
		$this->transaccion='SIGEFO_COMNIV_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_competencia_nivel','id_competencia_nivel','int4');
		$this->setParametro('id_competencia','id_competencia','int4');
		$this->setParametro('nivel','nivel','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
        $this->setParametro('descripcion','descripcion','varchar');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCompetenciaNivel(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_competencia_nivel_ime';
		$this->transaccion='SIGEFO_COMNIV_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_competencia_nivel','id_competencia_nivel','int4');
        $this->setParametro('id_competencia','id_competencia','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>