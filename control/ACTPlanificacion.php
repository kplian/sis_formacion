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
		$this->objParam->defecto('ordenacion','id_planificacion');

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
        $this->objParam->defecto('ordenacion','uop.id_uo');
        $this->objParam->defecto('dir_ordenacion','asc');

        if ($this->objParam->getParametro('id_uo') != '') {
            $this->objParam->addFiltro("uop.id_uo in (".$this->objParam->getParametro('id_uo').")  ");
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