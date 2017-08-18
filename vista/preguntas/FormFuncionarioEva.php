<?php 
/**
 * @package pXP
 * @file gen-Curso.php
 * @author  (admin)
 * @date 23-01-2017 13:34:58
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    var v_maestro=null;

    Phx.vista.FormFuncionarioEva  = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
				this.maestro = config.maestro;
                this.initButtons = [this.contenidoImagen];
			    v_maestro = config;

				Phx.vista.FormFuncionarioEva.superclass.constructor.call(this, config);
				Phx.CP.loadingHide(); //agregado para filtro y enviar parametro
				
				this.init();
				this.grid.addListener('cellclick', this.oncellclick,this);
				this.grid.addListener('afteredit', this.onAfterEdit, this);

				
				
				//this.grid.addListener('cellclick', this.selectNext,this);
				this.store.baseParams = {id_gestion: v_maestro.data.id_gestion,tipo: v_maestro.data.tipo,id_curso: v_maestro.data.id_curso, id_usuario: Phx.CP.config_ini.id_usuario};//agregado para filtro y enviar parametro
				this.load({params: {start: 0, limit: this.tam_pag}})
				
				this.iniciarEventos();    
				


            },

            iniciarEventos: function(){
                this.CargarEncabezado();	
            },
            getDatosKeyPres:function(){
            	return tipo_pregunta;
            },
		    onAfterEdit:function(prueba,x){
		
		       var columna=prueba.field;
		       /*var cod_id_linea=prueba.record.data['respuesta'];
		       var cod_linea_padre=prueba.record.data['cod_linea_padre'];
		       var peso=prueba.record.data['peso'];
		       var array_hijos=(prueba.record.data['cod_hijos']).split(',');
		       var sum_avance_padre=0;*/
		
		       //console.log("me", prueba.record.data['feb17']);

		       
		       console.log("probar stores  ", prueba);
		
		       console.log("probar respuesta  ",prueba.record.data['respuesta']);
		       
		        console.log("probar tiop  ",prueba.record.data['tipo']);
		        console.log("probar nivel  ",prueba.record.data['nivel']);
		        if(prueba.record.data['nivel']=='2' && prueba.record.data['tipo'] == 'Selección'){
		        	if(prueba.record.data['respuesta']=='Muy bueno'|| prueba.record.data['respuesta']=='Bueno' || prueba.record.data['respuesta']=='Regular'|| prueba.record.data['respuesta']=='Insuficiente'){
		        		
		        	}
		        	else{
		        		prueba.record.set('respuesta',prueba.originalValue);
		        		alert("ALERTA!! No puede escribir, tiene que seleccionar una respuesta. Se borrara la ultima respuesta cambiada");
		        	}
		        }
		
		    },
		    validarTipoInput:function(record){
		    	prueba.record.set('respuesta','');
		    },
		    contenidoImagen: new Ext.form.FormPanel({
		     name: 'encabezado',
		     id:'encabezado'
		     //inputType: 'hidden',
		    }),
		    CargarEncabezado:function(){
		    	var encab='<br><div style="margin: 0 auto;  width: 600px; padding: 1em; border: 1px solid #CCC; border-radius: 1em;">';
		    	var encab=encab+'<div> <label for="name"><b>NOMBRE CURSO &nbsp;:</b></label> <label for="name">'+v_maestro.data.curso+'</label> </div>';
		    	var encab=encab+'<div> <label for="name"><b>FECHA INICIO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :<b> </label><label for="name">'+v_maestro.data.fecha_inicio+'</label> </div>';
		    	var encab=encab+'<div> <label for="name"><b>FECHA FIN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b></label> <label for="name">'+v_maestro.data.fecha_fin+'</label> </div>';
		    	var encab=encab+'<div> <label for="name"><b>FUNCIONARIO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b></label> <label for="name">'+v_maestro.data.usuario+'</label> </div>  </div><br>';
		    	document.getElementById("encabezado").innerHTML = encab;
		    	//alert(Phx.CP.config_ini.id_usuario);
		    },
		    selectRecords : function(records, keepExisting){
		    	console.log("entro");
		        if(!keepExisting){
		            this.clearSelections();
		        }
		        var ds = this.grid.store,
		            i = 0,
		            len = records.length;
		        for(; i < len; i++){
		            this.selectRow(ds.indexOf(records[i]), true);
		        }
		    },
		    /*selectNext : function(keepExisting){
		    	console.log('entro al record juan seleccionado ',keepExisting);
		        if(this.hasNext()){
		            this.selectRow(this.last+1, keepExisting);
		            this.grid.getView().focusRow(this.last);
		            return true;
		        }
		        return false;
		    },*/
	       	oncellclick : function(grid, rowIndex, columnIndex, e) {
		        var record = this.store.getAt(rowIndex),
		            fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name
		
		       console.log(this.store);
		        if(record.data.tipo=='Selección'){
		        	this.Cmp.respuesta.store.events.expand=true;
		        	this.Cmp.respuesta.store.loadData(this.arrayStore.Selección) ;
		        }
		        if(record.data.tipo=='Texto'){
		        	
		        	this.Cmp.respuesta.store.loadData(this.arrayStore.Texto) ;
		        }
		        if(record.data.tipo!='Selección' && record.data.tipo!='Texto' && fieldName=='respuesta'){
		        	alert("ALERTA!! No responder las filas de color azul");
		        }
		        if(record.data.nivel=='1'){
		        	//alert("corregir que no se edite los campos de nivel 1");
		        }
	       },
			arrayStore :{
			                	'Selección':[
			                	            ['Muy bueno','Muy bueno'],
			                                ['Bueno','Bueno'],
			                                ['Regular','Regular'],
			                                ['Insuficiente','Insuficiente'],
			                   
			                     ],
			                	
			                	'Texto':[ ],
			                                
				},
            Atributos: [
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_temporal'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_pregunta'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'pregunta',
                        fieldLabel: 'Pregunta',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 500,
		                renderer: function (value, p, record, rowIndex, colIndex){
		
		                   var espacion_blanco="";
		                   var duplicar="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		                   var nivel = record.data.nivel==null?0:record.data.nivel;
		                   var espacion_blanco = duplicar.repeat(nivel);
		                  
		                   if(record.data.nivel ==1){
		                   	    p.style="background-color:#cce6ff; width: 550px;";
		                   	    return  String.format('<div style="vertical-align:middle;text-align:left;"> '+''+' <img src="../../../lib/imagenes/a_form_edit.png"> '+ record.data.pregunta+' </div>');
		                   }
		                   else{
		                   	    return  String.format('<div style="vertical-align:middle;text-align:left;"> '+espacion_blanco+' <img src="../../../lib/imagenes/a_form.png"> '+ record.data.pregunta+' </div>');
		                   }
		                },
		                gwidth: 500,
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'pregunta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true,
                },
	            {
	                    config: {
	                           name: 'respuesta',
	                           fieldLabel: 'Respuesta',
	                           allowBlank: false,
	                           emptyText: 'Elija una opción...',
	                           store: new Ext.data.ArrayStore({
			                        id: 0,
			                        fields: [
			                            'respuesta'
			                        ],
			                        data: [['Muy bueno'], ['Bueno'], ['Regular'], ['Insuficiente']]
	                           }),
	                           valueField: 'respuesta',
	                           displayField: 'respuesta',
	                           gdisplayField: 'respuesta',
	                           hiddenName: 'respuesta',
	                           //forceSelection: true,
	                           typeAhead: false,
	                           triggerAction: 'all',
	                           lazyRender: true,
	                           mode: 'local',
	                           pageSize: 15,
	                           queryDelay: 1000,
	                           anchor: '80%',
	                           gwidth: 150,
	                           minChars: 2,
	                           renderer : function(value, p, record) {
				                   if(record.data.nivel ==1){
				                   	    p.style="background-color:#cce6ff;";
				                   }
				                  
                                   return String.format('{0}', record.data['respuesta']);
	                           },
	                           gwidth: 200,
	                           /*enableKeyEvents: true,
						       onKeyPress : function(e,w,r){
						       		
						       	  console.log("entro " ,r);

							       if(tipo_pregunta=='seleccion'){
							       	   alert('Seleccione una respuesta');
							       }
							       else{
							        
							       }
						         
						       },*/
	                           //regex: '/^[1-9]\d*$|^[0-9]+([.]\d+)$|^-?\d+$|^-?\d+([.]\d+)$/',
	                           //maskRe: '/^[1-9]\d*$|^[0-9]+([.]\d+)$|^-?\d+$|^-?\d+([.]\d+)$/',
	                    },
	                    type: 'ComboBox',
	                    id_grupo: 0,
	                    filters: {pfiltro: 'respuesta',type: 'string'},
	                    grid: true,
	                    form: true,
	                    egrid:true,
	            },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'tipo'
                    },
                    type: 'Field',
                    form: true
                },
                /*{
                    config: {
                        name: 'tipo',
                        fieldLabel: 'Tipo de pregunta',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 500,
                        renderer : function(value, p, record) {
		                   if(record.data.nivel ==1){
		                   	    p.style="background-color:#cce6ff;";
		                   }
		                   if(record.data.tipo =='Selección' || record.data.tipo =='Texto'){
		                   	     return String.format('{0}', record.data['tipo']);
		                   }
		                   else{
		                   	    return '';
		                   }
                          
                       }

                    },
                    type: 'TextField',
                    filters: {pfiltro: 'tipo', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },*/
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'nivel'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_usuario_reg'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_curso'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_usuario'
                    },
                    type: 'Field',
                    form: true
                },
						
            ],
            tam_pag: 50,
            argumentSave: {},
            timeout: Phx.CP.config_ini.timeout,
    		conexionFailure: Phx.CP.conexionFailure,
            title: 'Cuestionario',
            ActSave: '../../sis_formacion/control/Curso/insertarCuestionario',
            ActList: '../../sis_formacion/control/Curso/listarPreguntas',
            id_store: 'id_temporal',
            fields: [
              	'id_temporal',
				{name:'id_pregunta', type: 'numeric'},				
				{name:'pregunta', type: 'varchar'},
				{name:'respuesta', type: 'varchar'},
				{name:'tipo', type: 'varchar'},
				{name:'nivel', type: 'numeric'},
				{name:'id_usuario_reg', type: 'numeric'},	
				{name:'id_curso', type: 'numeric'},
				{name:'id_usuario', type: 'numeric'},
            ],
            sortInfo: {
                field: 'id_temporal',
                direction: 'ASC'
            },
			bdel:false,
			bsave:true, 
			bedit:false, 
			bnew:false,
	        onButtonNew: function() {
		       	Phx.vista.Curso.superclass.onButtonNew.call(this);
		       
		    },
	        onButtonEdit: function () {
	            Phx.vista.FormFuncionarioEva.superclass.onButtonEdit.call(this);
	        },
            loadValoresIniciales: function () {
                Phx.vista.FormFuncionarioEva.superclass.loadValoresIniciales.call(this);
		                                             
            },
			onButtonSave:function(o){
				var filas=this.store.getModifiedRecords();
				if(filas.length>0){	
					if(confirm("Está seguro de guardar los cambios?")){
							var data={};
							for(var i=0;i<filas.length;i++){
								data[i]=filas[i].data;
								data[i]._fila=this.store.indexOf(filas[i])+1
								this.agregarArgsExtraSubmit(filas[i].data);
								Ext.apply(data[i],this.argumentExtraSubmit);
							   
							}
							Phx.CP.loadingShow();
					        Ext.Ajax.request({
					        	url:this.ActSave,
					        	params:{_tipo:'matriz','row':String(Ext.util.JSON.encode(data)) , id_curso: v_maestro.data.id_curso},
							
								isUpload:this.fileUpload,
								success:this.successSaveFileUpload,
								//argument:this.argumentSave,
								failure: this.conexionFailure,
								timeout:this.timeout,
								scope:this
					        });
				    }			
				}
			},
        }
    )
</script>