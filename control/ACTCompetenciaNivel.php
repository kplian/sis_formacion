<?php
/**
*@package pXP
*@file gen-ACTCompetenciaNivel.php
*@author  (jjimenez)
*@date 11-06-2018 20:42:44
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCompetenciaNivel extends ACTbase{    
			
	function listarCompetenciaNivel(){
		$this->objParam->defecto('ordenacion','id_competencia_nivel');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		if($this->objParam->getParametro('id_competencia')){
			//$this->objParam->addFiltro("id_competencia = 0"); 
			$this->objParam->addFiltro("id_competencia = ".$this->objParam->getParametro('id_competencia')); 
		}
		else{
			$this->objParam->addFiltro("id_competencia = 0"); 
		}
		
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCompetenciaNivel','listarCompetenciaNivel');
		} else{
			$this->objFunc=$this->create('MODCompetenciaNivel');
			
			$this->res=$this->objFunc->listarCompetenciaNivel($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCompetenciaNivel(){
		$this->objFunc=$this->create('MODCompetenciaNivel');	
		if($this->objParam->insertar('id_competencia_nivel')){
			$this->res=$this->objFunc->insertarCompetenciaNivel($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCompetenciaNivel($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCompetenciaNivel(){
			$this->objFunc=$this->create('MODCompetenciaNivel');	
		$this->res=$this->objFunc->eliminarCompetenciaNivel($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>