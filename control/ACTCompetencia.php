<?php

/**

 * @package pXP
 * @file gen-ACTCompetencia.php
 * @author  (admin)
 * @date 04-05-2017 19:30:13
 * @description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 */
class ACTCompetencia extends ACTbase
{
 
    function listarCompetencia()
    {
        $this->objParam->defecto('ordenacion', 'id_competencia');

        $this->objParam->defecto('dir_ordenacion', 'asc');
        if ($this->objParam->getParametro('tipoReporte') == 'excel_grid' || $this->objParam->getParametro('tipoReporte') == 'pdf_grid') {
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODCompetencia', 'listarCompetencia');
        } else {

            if($this->objParam->getParametro('id_cargos') != ''){
                $this->objParam->addFiltro("cp.id_cargo in (".$this->objParam->getParametro('id_cargos').")  ");
            }
            $this->objFunc = $this->create('MODCompetencia');

            $this->res = $this->objFunc->listarCompetencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
	function listarCompetenciaCargo(){
		$this->objParam->defecto('ordenacion','id_competencia');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		$this->objParam->addFiltro("cc.id_cargo = ".$this->objParam->getParametro('id_cargo')); 
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCompetencia','listarCompetenciaCargo');
		} else{
			$this->objFunc=$this->create('MODCompetencia');
			
			$this->res=$this->objFunc->listarCompetenciaCargo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function listarCargoCompetencia(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='orga.ft_cargo_sel';
		$this->transaccion='OR_CCOMPETENCIA_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_uo','id_uo','integer');
				
		//Definicion de la lista del resultado del query
		$this->captura('id_cargo','int4');
		$this->captura('id_uo','int4');
		$this->captura('id_tipo_contrato','int4');
		$this->captura('id_lugar','int4');
		$this->captura('id_temporal_cargo','int4');
		$this->captura('id_escala_salarial','int4');
		$this->captura('codigo','varchar');
		$this->captura('nombre','varchar');
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
		
		$this->captura('cod_competencia','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

    
    function insertarCompetencia()
    {
        $this->objFunc = $this->create('MODCompetencia');
        if ($this->objParam->insertar('id_competencia')) {
            $this->res = $this->objFunc->insertarCompetencia($this->objParam);
        } else {
            $this->res = $this->objFunc->modificarCompetencia($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function eliminarCompetencia()
    {
        $this->objFunc = $this->create('MODCompetencia');
        $this->res = $this->objFunc->eliminarCompetencia($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function insertarCargoCompetencia(){
    	
    		$this->objFunc=$this->create('MODCompetencia');	
			$this->res=$this->objFunc->insertarCargoCompetencia($this->objParam);			

		$this->res->imprimirRespuesta($this->res->generarJson());
    }
	function listarCargo(){
		$this->objParam->defecto('ordenacion','id_cargo');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		if ($this->objParam->getParametro('id_uo') != '') {
			$this->objParam->addFiltro("cargo.id_uo = ". $this->objParam->getParametro('id_uo'));
		}
        if ($this->objParam->getParametro('id_competencias')) {
            $this->objParam->addFiltro(" cc.id_competencia in (". $this->objParam->getParametro('id_competencias')." ) ");
        }
				
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCompetencia','listarCargo');
		} else{
			$this->objFunc=$this->create('MODCompetencia');
			
			$this->res=$this->objFunc->listarCargo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function eliminarCargoCompetencia(){
		$this->objFunc=$this->create('MODCompetencia');	
		$this->res=$this->objFunc->eliminarCargoCompetencia($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}


}

?>