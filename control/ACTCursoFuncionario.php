<?php
/**
*@package pXP
*@file gen-ACTCursoFuncionario.php
*@author  (admin)
*@date 26-01-2017 16:26:09
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCursoFuncionario extends ACTbase{    
			
	function listarCursoFuncionario(){
		$this->objParam->defecto('ordenacion','id_curso_funcionario');

		$this->objParam->defecto('dir_ordenacion','asc');
		$this->objParam->addFiltro("cufu.id_curso = ".$this->objParam->getParametro('id_curso')); 
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCursoFuncionario','listarCursoFuncionario');
		} else{
			$this->objFunc=$this->create('MODCursoFuncionario');
			
			$this->res=$this->objFunc->listarCursoFuncionario($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCursoFuncionario(){
		$this->objFunc=$this->create('MODCursoFuncionario');	
		if($this->objParam->insertar('id_curso_funcionario')){
			$this->res=$this->objFunc->insertarCursoFuncionario($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCursoFuncionario($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCursoFuncionario(){
			$this->objFunc=$this->create('MODCursoFuncionario');	
		$this->res=$this->objFunc->eliminarCursoFuncionario($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>