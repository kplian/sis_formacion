<?php
/**
*@package pXP
*@file gen-ACTPlanificacion.php
*@author  (admin)
*@date 26-04-2017 20:37:24
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPlanificacion extends ACTbase{

	function listarPlanificacion(){
		$this->objParam->defecto('ordenacion','sigefop.nombre_planificacion');
        
		//filtro desde curso para el combo
		if ($this->objParam->getParametro('id_gestion')) {
            $this->objParam->addFiltro("sigefop.id_gestion  =". $this->objParam->getParametro('id_gestion'));
        }
		else{
			$this->objParam->addFiltro("sigefop.id_gestion  = 0");
		}
		//
		
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPlanificacion','listarPlanificacion');
		} else{
			$this->objFunc=$this->create('MODPlanificacion');

			$this->res=$this->objFunc->listarPlanificacion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarPlanificacion(){
		$this->objFunc=$this->create('MODPlanificacion');
		if($this->objParam->insertar('id_planificacion')){
			$this->res=$this->objFunc->insertarPlanificacion($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarPlanificacion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarPlanificacion(){
		$this->objFunc=$this->create('MODPlanificacion');
		$this->res=$this->objFunc->eliminarPlanificacion($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}


    function listarCargo(){
        $this->objParam->defecto('ordenacion','uo.nombre_cargo');
        $this->objParam->defecto('dir_ordenacion','asc');

        if ($this->objParam->getParametro('id_uo')) {
            $this->objParam->addFiltro("euo.id_uo_padre = ".$this->objParam->getParametro('id_uo'));
        }
		else{
			$this->objParam->addFiltro("euo.id_uo_padre = 0");
		} 

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODPlanificacion','listarCargo');
        } else{
            $this->objFunc=$this->create('MODPlanificacion');

            $this->res=$this->objFunc->listarCargo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function listarGerenciauo(){

        $this->objParam->defecto('ordenacion','uo.nombre_unidad');
        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);

            $this->res = $this->objReporte->generarReporteListado('MODPlanificacion','listarGerenciauo');
        } else{
            $this->objFunc=$this->create('MODPlanificacion');
            $this->res=$this->objFunc->listarGerenciauo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
	


}

?>