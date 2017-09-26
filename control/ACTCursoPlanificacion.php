<?php
/**
*@package pXP
*@file gen-ACTCursoPlanificacion.php
*@author  (admin)
*@date 22-01-2017 21:35:03
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCursoPlanificacion extends ACTbase{    
			
	function listarCursoPlanificacion(){
		$this->objParam->defecto('ordenacion','id_curso_planificacion');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		$this->objParam->addFiltro("cupl.id_curso = ".$this->objParam->getParametro('id_curso')); 
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCursoPlanificacion','listarCursoPlanificacion');
		} else{
			$this->objFunc=$this->create('MODCursoPlanificacion');
			
			$this->res=$this->objFunc->listarCursoPlanificacion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCursoPlanificacion(){
		$this->objFunc=$this->create('MODCursoPlanificacion');	
		if($this->objParam->insertar('id_curso_planificacion')){
			$this->res=$this->objFunc->insertarCursoPlanificacion($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCursoPlanificacion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCursoPlanificacion(){
			$this->objFunc=$this->create('MODCursoPlanificacion');	
		$this->res=$this->objFunc->eliminarCursoPlanificacion($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>