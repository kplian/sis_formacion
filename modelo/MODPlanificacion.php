<?php
/**
*@package pXP
*@file gen-MODPlanificacion.php
*@author  (admin)
*@date 26-04-2017 20:37:24
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPlanificacion extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPlanificacion(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigefo.ft_planificacion_sel';
		$this->transaccion='SIGEFO_SIGEFOP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_planificacion','int4');
		$this->captura('id_gestion','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('cantidad_personas','int4');
		$this->captura('contenido_basico','text');
		$this->captura('nombre_planificacion','varchar');
		$this->captura('necesidad','text');
		$this->captura('horas_previstas','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('gestion','int4');
		$this->captura('desc_cargos','varchar');
		$this->captura('id_cargos','varchar');
		$this->captura('cod_criterio','varchar');
		$this->captura('desc_criterio','varchar');
        $this->captura('desc_competencia','varchar');
        $this->captura('id_competencias','varchar');
        $this->captura('desc_proveedores','varchar');
        $this->captura('id_proveedores','varchar');
        $this->captura('id_uo','varchar');
        $this->captura('desc_uo','varchar');

        //Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarPlanificacion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_planificacion_ime';
		$this->transaccion='SIGEFO_SIGEFOP_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('cantidad_personas','cantidad_personas','int4');
		$this->setParametro('contenido_basico','contenido_basico','text');
		$this->setParametro('nombre_planificacion','nombre_planificacion','varchar');
		$this->setParametro('necesidad','necesidad','text');
		$this->setParametro('horas_previstas','horas_previstas','int4');
        $this->setParametro('cod_criterio', 'cod_criterio', 'varchar');
        $this->setParametro('id_competencias', 'id_competencias', 'varchar');
        $this->setParametro('id_cargos', 'id_cargos', 'varchar');
        $this->setParametro('id_proveedores', 'id_proveedores', 'varchar');
        $this->setParametro('id_uo', 'id_uo', 'varchar');
        //Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPlanificacion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_planificacion_ime';
		$this->transaccion='SIGEFO_SIGEFOP_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_planificacion','id_planificacion','int4');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('cantidad_personas','cantidad_personas','int4');
		$this->setParametro('contenido_basico','contenido_basico','text');
		$this->setParametro('nombre_planificacion','nombre_planificacion','varchar');
		$this->setParametro('necesidad','necesidad','text');
		$this->setParametro('horas_previstas','horas_previstas','int4');

        $this->setParametro('cod_criterio', 'cod_criterio', 'varchar');
        $this->setParametro('id_cargos', 'id_cargos', 'varchar');
        $this->setParametro('id_competencias', 'id_competencias', 'varchar');
        $this->setParametro('id_proveedores', 'id_proveedores', 'varchar');
        $this->setParametro('id_uo', 'id_uo', 'varchar');

        //Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPlanificacion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigefo.ft_planificacion_ime';
		$this->transaccion='SIGEFO_SIGEFOP_ELI';
		$this->tipo_procedimiento='IME';	
		//Define los parametros para la funcion
		$this->setParametro('id_planificacion','id_planificacion','int4');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}


    function listarCargo(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sigefo.f_cargo_sel';
        $this->transaccion='SIGEFO_CARGO_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
       // $this->setParametro('tipo','tipo','varchar');
       // $this->setParametro('fecha','fecha','date');
       // $this->setParametro('id_uo','id_uo','integer');
        //Definicion de la lista del resultado del query
        $this->captura('id_cargo','int4');
        $this->captura('id_uo','int4');
        $this->captura('id_tipo_contrato','int4');
        $this->captura('id_lugar','int4');
        $this->captura('nombre','varchar');
        $this->captura('identificador','int4');
        $this->captura('id_uo_padre','int4');
        $this->captura('nombre_unidad_padre','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function listarGerenciauo(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='sigefo.ft_planificacion_sel';
        $this->transaccion='SIGEFO_SIGEFOCGU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
       // $this->setParametro('tipo','tipo','varchar');
       // $this->setParametro('fecha','fecha','date');
       // $this->setParametro('id_uo','id_uo','integer');
        //Definicion de la lista del resultado del query
        $this->captura('id_uo','int4');
        $this->captura('nombre_unidad','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
			
}
?>