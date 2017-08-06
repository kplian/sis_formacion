<?php
/**
*@package pXP
*@file gen-MODCompetencia.php
*@author  (admin)
*@date 04-05-2017 19:30:13
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCompetencia extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}

	function listarCompetencia(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_competencia_sel';
		$this->transaccion='SIGEFO_SIGEFOCO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
			 	
		//Definicion de la lista del resultado del query
		$this->captura('id_competencia','int4');
		$this->captura('tipo','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('competencia','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('cod_competencia','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
				
	function listarCompetenciaCombo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_competencia_sel';
		$this->transaccion='SIGEFO_COMCOMBO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
			 	
		//Definicion de la lista del resultado del query
		/*$this->captura('id_competencia','int4');
		$this->captura('tipo','varchar');
		$this->captura('estado_reg','varchar');*/
		
		$this->captura('competencia','varchar');
		$this->captura('id_uo','int4');
		$this->captura('id_competencia','int4');
		$this->captura('cod_competencia','int4');
		$this->captura('tipo','varchar');
		$this->captura('desc_competencia','varchar');
		/*$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('cod_competencia','int4');*/
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	function listarCompetenciaCargo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_competencia_sel';
		$this->transaccion='SIGEFO_CCOMP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_competencia','int4');
		$this->captura('tipo','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('competencia','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('cod_competencia','int4');
		$this->captura('id_cargo','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_competencia_ime';
		$this->transaccion='SIGEFO_SIGEFOCO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('competencia','competencia','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_competencia_ime';
		$this->transaccion='SIGEFO_SIGEFOCO_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_competencia','id_competencia','int4');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('competencia','competencia','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_competencia_ime';
		$this->transaccion='SIGEFO_SIGEFOCO_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_competencia','id_competencia','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
    
	function insertarCargoCompetencia(){
		$this->procedimiento='sigefo.ft_competencia_ime';
		$this->transaccion='SIGEFOCCO_INS';
		$this->tipo_procedimiento='IME';	

        $this->setParametro('cod_cargos','cargos','json_text');
		$this->setParametro('cod_competencias','competencias','json_text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	function listarCargo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_competencia_sel';
		$this->transaccion='SIGEFO_CCARGO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		/*$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_uo','id_uo','integer');*/
				
		//Definicion de la lista del resultado del query
	
		/*$this->captura('id_cargo','int4');
		$this->captura('id_uo','int4');
		$this->captura('id_tipo_contrato','int4');
		$this->captura('id_lugar','int4');
		$this->captura('id_temporal_cargo','int4');
		$this->captura('id_escala_salarial','int4');
		$this->captura('codigo','varchar');
		$this->captura('nombre_cargo','varchar');
		$this->captura('fecha_ini','date');
		$this->captura('estado_reg','varchar');
		$this->captura('fecha_fin','date');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		$this->captura('nombre_tipo_contrato','varchar');
		$this->captura('nombre_escala','varchar');
		$this->captura('nombre_oficina','varchar');
		$this->captura('acefalo','varchar');
		$this->captura('id_oficina','int4');
		$this->captura('identificador','int4');
		$this->captura('codigo_tipo_contrato','varchar');
		
		$this->captura('cod_cargo','int4');
		$this->captura('funcionario','varchar');*/
		

		$this->captura('id_cargo','int4');
		$this->captura('cod_cargo','int4');
		$this->captura('nombre_cargo','varchar');
		$this->captura('funcionario','varchar');
		$this->captura('id_competencia','int4');
		//$this->captura('estado_reg','varchar');
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	function eliminarCargoCompetencia(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_competencia_ime';
		$this->transaccion='SIGEFO_ECCOMPETENCIA';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('cod_competencias','competencias','json_text');
		$this->setParametro('id_cargo','id_cargo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>