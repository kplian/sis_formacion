<?php
/**
*@package pXP
*@file gen-ACTCursoCompetencia.php
*@author  (admin)
*@date 22-01-2017 20:25:54
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCursoCompetencia extends ACTbase{    
			
	function listarCursoCompetencia(){
		$this->objParam->defecto('ordenacion','id_curso_competencia');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		$this->objParam->addFiltro("cuco.id_curso = ".$this->objParam->getParametro('id_curso')); 
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCursoCompetencia','listarCursoCompetencia');
		} else{
			$this->objFunc=$this->create('MODCursoCompetencia');
			
			$this->res=$this->objFunc->listarCursoCompetencia($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCursoCompetencia(){
		$this->objFunc=$this->create('MODCursoCompetencia');	
		if($this->objParam->insertar('id_curso_competencia')){
			$this->res=$this->objFunc->insertarCursoCompetencia($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCursoCompetencia($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCursoCompetencia(){
			$this->objFunc=$this->create('MODCursoCompetencia');	
		$this->res=$this->objFunc->eliminarCursoCompetencia($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>