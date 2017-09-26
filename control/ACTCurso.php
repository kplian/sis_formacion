<?php
/**
*@package pXP
*@file gen-ACTCurso.php
*@author  (admin)
*@date 22-01-2017 15:35:03
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCurso extends ACTbase{
			
	function listarCurso(){
		$this->objParam->defecto('ordenacion','id_curso');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCurso','listarCurso');
		} else{
			$this->objFunc=$this->create('MODCurso');
			
			$this->res=$this->objFunc->listarCurso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCurso(){
		$this->objFunc=$this->create('MODCurso');	
		if($this->objParam->insertar('id_curso')){
			$this->res=$this->objFunc->insertarCurso($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCurso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCurso(){
			$this->objFunc=$this->create('MODCurso');	
		$this->res=$this->objFunc->eliminarCurso($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

    function listarPaisLugar(){
        $this->objParam->defecto('ordenacion','lug.id_lugar');

        $this->objParam->defecto('dir_ordenacion','asc');


        if ($this->objParam->getParametro('tipo') != '') {
            $this->objParam->addFiltro("lugp.tipo  in (''". $this->objParam->getParametro('tipo') . "'')");
        }
        if ($this->objParam->getParametro('id_lugar_padre') != '') {
            $this->objParam->addFiltro("lugp.id_lugar  =". $this->objParam->getParametro('id_lugar_padre') );
        }

		$this->objFunc=$this->create('MODCurso');
		$this->res=$this->objFunc->listarPaisLugar();
		$this->res->imprimirRespuesta($this->res->generarJson());
    }
	
	function listarCursoAvanceArb(){		
		$node = $this->objParam->getParametro('node');
        $id_correlativo= $this->objParam->getParametro('id_correlativo_key');
        $tipo_nodo = $this->objParam->getParametro('tipo_nodo_temp');			
		if ($node == 'id') {
            $this->objParam->addParametro('id_padre', '%');
        } else {
            $this->objParam->addParametro('id_padre', $id_correlativo);
        }				
        $this->objFunc = $this->create('MODCurso');
        $this->res = $this->objFunc->listarCursoAvanceArb();
        $this->res->setTipoRespuestaArbol();
        $arreglo = array();
     	array_push($arreglo, array('nombre' => 'id', 'valor' => 'id_correlativo_key'));
		array_push($arreglo, array('nombre' => 'id_p', 'valor' => 'id_uo_padre_temp'));
        array_push($arreglo, array('nombre' => 'qtip', 'valores' => '<b>#id_uo_t_temp# </b><br><b>#id_uo_padre_temp	#</b><br/><b>#cod_prioridad_temp#</b>'));
		      
 		$this->res->addNivelArbol('tipo_nodo_temp', 'raiz', array('leaf' => false, 'draggable' => false, 'allowDelete' => true, 'allowEdit' => true, 'cls' => 'folder', 'tipo_nodo_temp' => 'raiz', 'icon' => '../../../lib/imagenes/orga32x32.png'), $arreglo);
		$this->res->addNivelArbol('tipo_nodo_temp', 'hijo', array('leaf' => false, 'draggable' => false, 'allowDelete' => true, 'allowEdit' => true, 'tipo_nodo_temp' => 'hijo', 'icon' => '../../../lib/imagenes/alma32x32.png'), $arreglo);
        $this->res->imprimirRespuesta($this->res->generarJson());
	}

	function listarCursoAvanceDinamico(){		
		$this->objFunc=$this->create('MODCurso');	
		$this->res=$this->objFunc->listarCursoAvanceDinamico($this->objParam);		
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
		
	function GenerarColumnaMeses(){
		$this->objFunc=$this->create('MODCurso');	
		$this->res=$this->objFunc->GenerarColumnaMeses($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
    }	
	
	function insertarAvanceReal(){			
		$codigo= $this->objParam->getParametro('datos');
		$this->objFunc=$this->create('MODCurso');	
		$this->res=$this->objFunc->insertarAvanceReal($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}	
			
}

?>