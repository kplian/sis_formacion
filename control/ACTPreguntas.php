<?php
/**
*@package pXP
*@file gen-ACTPreguntas.php
*@author  (admin)
*@date 20-04-2017 00:51:06
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPreguntas extends ACTbase{    
			
	function listarPreguntas(){
		$this->objParam->defecto('ordenacion','id_pregunta');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPreguntas','listarPreguntas');
		} else{
			$this->objFunc=$this->create('MODPreguntas');
			 
			$this->res=$this->objFunc->listarPreguntas($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	 
	function listarPreguntasPro(){
		$this->objParam->defecto('ordenacion','id_pregunta');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPreguntas','listarPreguntasPro');
		} else{
			$this->objFunc=$this->create('MODPreguntas');
			
			$this->res=$this->objFunc->listarPreguntasPro($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function listarPreguntasFun(){
		$this->objParam->defecto('ordenacion','id_pregunta');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPreguntas','listarPreguntasFun');
		} else{
			$this->objFunc=$this->create('MODPreguntas');
			
			$this->res=$this->objFunc->listarPreguntasFun($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
		
				
	function insertarPreguntas(){
		$this->objFunc=$this->create('MODPreguntas');	
		if($this->objParam->insertar('id_pregunta')){
			$this->res=$this->objFunc->insertarPreguntas($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPreguntas($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPreguntas(){
			$this->objFunc=$this->create('MODPreguntas');	
		$this->res=$this->objFunc->eliminarPreguntas($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
		
		
	function insertarPreguntaPro(){
		$this->objFunc=$this->create('MODPreguntas');	
		if($this->objParam->insertar('id_pregunta')){
			$this->res=$this->objFunc->insertarPreguntaPro($this->objParam);			
		} 
		$this->res->imprimirRespuesta($this->res->generarJson());
	}	
	
	function insertarPreguntaFun(){
		$this->objFunc=$this->create('MODPreguntas');	
		if($this->objParam->insertar('id_pregunta')){
			$this->res=$this->objFunc->insertarPreguntaFun($this->objParam);			
		} 
		$this->res->imprimirRespuesta($this->res->generarJson());
	}		
}

?>