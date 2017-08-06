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
	var v_maestro =null;
	var valor;
	var valor2;

  //variables para recuperar datos de planificacion 
    var  v_gerencia;
	var  v_unidad_organizacional;
	var  v_competencias;
	var  v_nombre_planificacion;
	var  v_contenido_basico;
	var  v_horas_previstas;
	var  v_id_proveedor;
	
    Phx.vista.Curso = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
				this.maestro = config.maestro;
				this.initButtons = [this.cmbGestion];
				v_maestro = config.maestro;
				//llama al constructor de la clase padre
				Phx.vista.Curso.superclass.constructor.call(this, config);
				this.init();
				this.load({params: {start: 0, limit: this.tam_pag}})
				
				
				this.iniciarEventos();            
            },
            //
            cmbGestion: new Ext.form.ComboBox({
                fieldLabel: 'Gestion',
                allowBlank: true,
                emptyText: 'Gestion...',
                store: new Ext.data.JsonStore(
                    {
                        url: '../../sis_parametros/control/Gestion/listarGestion',
                        id: 'id_gestion',
                        root: 'datos',
                        sortInfo: {
                            field: 'gestion',
                            direction: 'DESC'
                        },
                        totalProperty: 'total',
                        fields: ['id_gestion', 'gestion'],
                        // turn on remote sorting
                        remoteSort: true,
                        baseParams: {par_filtro: 'gestion'}
                    }),
                valueField: 'id_gestion',
                triggerAction: 'all',
                displayField: 'gestion',
                hiddenName: 'id_gestion',
                mode: 'remote',
                pageSize: 50,
                queryDelay: 500,
                listWidth: '280',
                width: 80
            }),
            iniciarEventos: function () {
            	
                
                this.cmbGestion.on('select',
                       function (cmb, dat) {
                       	this.sm.clearSelections();
		                this.store.baseParams = {id_gestion: dat.data.id_gestion};
		                this.store.reload();
                }, this);
                
                
                this.Cmp.id_lugar_pais.on('select', function (Combo, dato) {
                    this.cargarPaiseLugares(Combo);
                }, this);
                
                this.Cmp.id_planificacion.on('select', function (Combo, dato) {


			            Ext.Ajax.request({
			                        url: '../../sis_formacion/control/Curso/datosPlanificacion',
			                        params: {
			                            'id_planificacion': Combo.getValue(),
			                        },
			                        success: this.RespuestaPlanificacion,
			                        failure: this.conexionFailure,
			                        timeout: this.timeout,
			                        scope: this
			            });
			            
		                this.Cmp.id_uo.setValue('');  
		                this.Cmp.id_unidad_organizacional.setValue(''); 
		                this.Cmp.id_competencias.setValue(''); 
                        this.Cmp.nombre_curso.setValue('');
                        this.Cmp.contenido.setValue('');
                        this.Cmp.horas.setValue('');
                        this.Cmp.id_proveedor.setValue('');
		                
					    this.Cmp.id_uo.store.load({params:{start:0,limit:this.tam_pag}, 
				           callback : function (r) {

				                      
						              for(i=0;i<r.length;i++){
						              	   // console.log('conteo id uo',r[i].data.cod_uo);
							              	 if(String(r[i].data.cod_uo).trim()==String(v_gerencia).trim()){
							              		
								              		 this.Cmp.id_uo.setValue(r[i].data.id_uo);
								              		 
		                                             this.Cmp.id_unidad_organizacional.store.setBaseParam('id_uo', r[i].data.id_uo);
		                                             this.Cmp.id_unidad_organizacional.modificado = true;
	
													 this.Cmp.id_unidad_organizacional.store.load({params:{start:0,limit:this.tam_pag}, 
												           callback : function (x) {
												           	
														              for(cont=0;cont<x.length;cont++){
														              	    //console.log('conteo id_unidad_organizacional',x);
															              	if(String(x[cont].data.cod_cargo).trim()==String(v_unidad_organizacional).trim()){
															              		
															              		 this.Cmp.id_unidad_organizacional.setValue(x[cont].data.id_cargo);  
	
															              		 this.Cmp.id_competencias.store.setBaseParam('id_uo', this.Cmp.id_unidad_organizacional.value);
									                                             this.Cmp.id_competencias.modificado = true;
									                                             
                                                                                  //filtrar funcionarios
									                                              this.Cmp.id_funcionarios.store.setBaseParam('id_uo', this.Cmp.id_unidad_organizacional.value);
		                                                                          this.Cmp.id_funcionarios.modificado = true;
									                                              //
									                                             
																				 this.Cmp.id_competencias.store.load({params:{start:0,limit:this.tam_pag}, 
																			           callback : function (y) {
																			           	       var concatenarCompetencias='';
																			           	       var concatenarIduo='';
																			           	       var banderaInicio=0;
																					              for(cont1=0;cont1<y.length;cont1++){

																					              	    for (c=0;c<v_competencias.length;c++){
																					              	    	if(String(y[cont1].data.cod_competencia).trim() == String(v_competencias[c]).trim()){
																					              	    		banderaInicio++;
																					              	    		if(banderaInicio==1){
																					              	    			concatenarCompetencias+=y[cont1].data.id_competencia;
																					              	    			concatenarIduo+=y[cont1].data.id_uo;
																					              	    		}
																					              	    		else{
																					              	    			concatenarCompetencias+=','+y[cont1].data.id_competencia;
																					              	    			concatenarIduo+=','+y[cont1].data.id_uo;
																					              	    		}
																					              	    		
																					              	    		//
																												 this.Cmp.id_proveedor.store.load({params:{start:0,limit:this.tam_pag}, 
																											           callback : function (z) {
																											           	  for(cc=0;cc<z.length;cc++){
																												           	    if(String(z[cc].data.cod_proveedor).trim()==String(v_id_proveedor).trim()){   
																												           	         
																														             this.Cmp.id_proveedor.setValue(z[cc].data.id_proveedor);  
																														        }
																													      }
																													       
																											            }, scope : this
																											     }); 
																					              	    		//
																					              	    		
																					              	    	}
																					              	    	
																					              	    }
																					              }
																					              this.Cmp.id_competencias.setValue(concatenarCompetencias);  

																			                      this.Cmp.nombre_curso.setValue(v_nombre_planificacion);
                                                                                                  this.Cmp.contenido.setValue(v_contenido_basico);
                                                                                                  this.Cmp.horas.setValue(v_horas_previstas);
                                                                                                  
                                                                                                  this.Cmp.id_funcionarios.store.setBaseParam('id_uo',concatenarIduo);
		                                                                                          this.Cmp.id_funcionarios.modificado = true;
																			                   
																			            }, scope : this
																			     }); 
																			     
									                                             return cont;
															              	}
														              }
														               
												                   
												            }, scope : this
												     }); 
		                                             return i;
							              	}
						              }
				                                  
				                   
				            }, scope : this
				        }); 


                }, this);
                this.Cmp.id_uo.on('select', function (Combo, dato) {
                	
                	 this.Cmp.id_unidad_organizacional.setValue(''); 
		             this.Cmp.id_competencias.setValue(''); 
		             
                     this.Cmp.id_unidad_organizacional.store.setBaseParam('id_uo', Combo.getValue());
                     this.Cmp.id_unidad_organizacional.modificado = true;
                     

                }, this);
                this.Cmp.id_unidad_organizacional.on('select', function (Combo, dato) {
                	
                        this.Cmp.id_competencias.store.setBaseParam('id_uo', Combo.getValue());
                        this.Cmp.id_competencias.modificado = true;
        
                }, this);
                
            },
	       RespuestaPlanificacion: function (s,m){
	          this.maestro = m;
	          var respuesta_planificacion = s.responseText.split('%');
	          //console.log('repuesta planificacion ',respuesta_planificacion[1]);
	          //console.log('repuesta planificacion ',respuesta_planificacion[2]);
	          
	          v_unidad_organizacional=respuesta_planificacion[1];
	          v_gerencia=respuesta_planificacion[2];
	          try{
	          	v_competencias=respuesta_planificacion[3].split(',');
	          }catch(error){
	          	v_competencias='';
	          }
			  v_nombre_planificacion=respuesta_planificacion[4];
			  v_contenido_basico=respuesta_planificacion[5];
			  v_horas_previstas=respuesta_planificacion[6];
              v_id_proveedor=respuesta_planificacion[7];
	       },
            //
            cargarPaiseLugares: function (Combo) {
                this.Cmp.id_lugar.store.setBaseParam('id_lugar_padre', Combo.getValue());
                this.Cmp.id_lugar.modificado = true;
            },
            //   
	        onButtonEdit: function () {
	            Phx.vista.Curso.superclass.onButtonEdit.call(this);
	            this.cargarPaiseLugares(this.Cmp.id_lugar_pais);
	            
                
                this.Cmp.id_unidad_organizacional.modificado = true;
                this.Cmp.id_unidad_organizacional.store.setBaseParam('id_uo', this.Cmp.id_uo.getValue());
                
                //console.log("id de unidad",this.Cmp.id_unidad_organizacional);
                this.Cmp.id_competencias.modificado = true;
                this.Cmp.id_competencias.store.setBaseParam('id_uo', this.Cmp.id_unidad_organizacional.value);
                
	        },
	        //
	        onReloadPage: function (m) {
	           this.maestro = m;
	           console.log('maestro:',this.maestro);        
	        },
	        //	                
          	onSubmit: function(o, x, force) {
    			var me = this;    			
				if (me.form.getForm().isValid() || force===true) {
		            Phx.CP.loadingShow();
		            Ext.apply(me.argumentSave, o.argument); 
		            
	            	var a = me.Cmp.origen.lastSelectionText;
	            	if(a=='Externo' || a=='Interno'){
	            		if(me.Cmp.id_proveedor.lastSelectionText === undefined || me.Cmp.id_proveedor.lastSelectionText === ''){
	            			alert("Seleccione algun proveedor");
		            		Phx.CP.loadingHide();
	            		}else{
	            			Ext.Ajax.request({
								url: '../../sis_formacion/control/Curso/insertarCurso',
								params: me.getValForm,
								success: me.successSave,
								argument: me.argumentSave,
								failure: me.conexionFailure,
								timeout: me.timeout,
								scope: me
							});	
	            		}	
	            	}else{
	            		Ext.Ajax.request({
							url: '../../sis_formacion/control/Curso/insertarCurso',
							params: me.getValForm,
							success: me.successSave,
							argument: me.argumentSave,
							failure: me.conexionFailure,
							timeout: me.timeout,
							scope: me
						});
	            	}		
        		}					
			},
			//
			successSave: function(resp) {
    	  		this.store.rejectChanges();
				Phx.CP.loadingHide();
				if(resp.argument && resp.argument.news){
					if(resp.argument.def == 'reset'){
					  this.onButtonNew();
					}					
					this.loadValoresIniciales()
				}
				else{
					this.window.hide();
				}		
				this.reload();
			},
			//
			getValForm: function() {
        		var resp = {};
		        for (var i = 0; i < this.Componentes.length; i++) {
		            var ac = this.Atributos[i];
		            var cmp = this.Componentes[i]
		            var swc = true;
		            if (ac.vista) {
		                swc = false;
		                for (var _p in ac.vista) {
		                    if (this.nombreVista == ac.vista[_p]) {
		                        swc = true;
		                        break;
		                    }
		                }
		            }		
		            if (ac.form != false && swc) {
		                var _name = ac.config.name;
		                if (cmp.getValue() != '' && ac.type == 'DateField' && ac.config.format) {
		                    resp[_name] = cmp.getValue().dateFormat(ac.config.format)
		                    } 
		              else {
		              	    if(ac.type == 'ComboBox' && ac.config.rawValueField){
		              	    	resp[_name] =cmp.getValue();
		              	    	if ( cmp.getRawValue()==resp[_name] ){
		              	    		resp[ac.config.rawValueField] = cmp.getRawValue();
		              	    		resp[_name]=null;
		              	    	}
		              	    }
		              	    else{
		                        resp[_name] = cmp.getValue();
		              	    }
		                }
		            }
		        }
		        this.agregarArgsExtraSubmit();
		        this.agregarArgsBaseSubmit();
		        Ext.apply(resp, this.argumentExtraSubmit);
		        Ext.apply(resp, this.argumentBaseSubmit);
		        return resp
		    },    	  	
			//
            Atributos: [
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
                        name: 'id_planificacion',
                        fieldLabel: 'Planificacion',
                        allowBlank: false,
                        emptyText: 'Planificacion...',
                        blankText: 'Planificacion',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_formacion/control/Planificacion/listarPlanificacion',
                            id: 'id_planificacion',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre_planificacion',
                                direction: 'DESC'
                            },
                            totalProperty: 'total',
                            fields: ['id_planificacion', 'nombre_planificacion'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'nombre_planificacion'}
                        }),
                        valueField: 'id_planificacion',
                        displayField: 'nombre_planificacion',
                        gdisplayField: 'planificacion',
                        hiddenName: 'id_planificacion',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 50,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['planificacion']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'scu.planificacion', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        fieldLabel: 'id_gestion',
                        inputType: 'hidden',
                        name: 'id_gestion'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'gestion',
                        fieldLabel: 'Gestion',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 500
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'cur.gestion', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'nombre_curso',
                        fieldLabel: 'Curso',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 500
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'cur.nombre_curso', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'contenido',
                        fieldLabel: 'Contenido',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 1000
                    },
                    type: 'TextArea',
                    filters: {pfiltro: 'cur.contenido', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
	            {
	                    config: {
	                           name: 'cod_tipo',
	                           fieldLabel: 'Tipo',
	                           allowBlank: false,
	                           emptyText: 'Elija una opción...',
	                           store: new Ext.data.ArrayStore({
			                        id: 0,
			                        fields: [
			                            'cod_tipo'
			                        ],
			                        data: [['Seminario'], ['Curso'], ['Difusión']]
	                           }),
	                           valueField: 'cod_tipo',
	                           displayField: 'cod_tipo',
	                           gdisplayField: 'cod_tipo',
	                           hiddenName: 'cod_tipo',
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
	                                  return String.format('{0}', record.data['cod_tipo']);
	                           }
	                    },
	                    type: 'ComboBox',
	                    id_grupo: 0,
	                    filters: {pfiltro: 'cur.cod_tipo',type: 'string'},
	                    grid: false,
	                    form: true
	                    //,egrid:true,
	            },
                {
                    config: {
                        name: 'horas',
                        fieldLabel: 'Horas',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'cur.horas', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
	            {
	                    config: {
	                           name: 'cod_prioridad',
	                           fieldLabel: 'Prioridad',
	                           allowBlank: false,
	                           emptyText: 'Elija una opción...',
	                           store: new Ext.data.ArrayStore({
			                        id: 0,
			                        fields: [
			                            'cod_prioridad'
			                        ],
			                        data: [['Alta'], ['Media'], ['Baja']]
	                           }),
	                           valueField: 'cod_prioridad',
	                           displayField: 'cod_prioridad',
	                           gdisplayField: 'cod_prioridad',
	                           hiddenName: 'cod_prioridad',
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
	                                  return String.format('{0}', record.data['cod_prioridad']);
	                           }
	                    },
	                    type: 'ComboBox',
	                    id_grupo: 0,
	                    filters: {pfiltro: 'cur.cod_prioridad',type: 'string'},
	                    grid: true,
	                    form: true
	                    //,egrid:true,
	            },
                {
                    config: {
                        name: 'peso',
                        fieldLabel: 'Peso',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'scu.peso', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
	            {
	                    config: {
	                           name: 'cod_clasificacion',
	                           fieldLabel: 'Clasificación',
	                           allowBlank: false,
	                           emptyText: 'Elija una opción...',
	                           store: new Ext.data.ArrayStore({
			                        id: 0,
			                        fields: [
			                            'cod_clasificacion'
			                        ],
			                        data: [['Formación'], ['Capacitación'], ['Entrenamiento'], ['Especialización']]
	                           }),
	                           valueField: 'cod_clasificacion',
	                           displayField: 'cod_clasificacion',
	                           gdisplayField: 'cod_clasificacion',
	                           hiddenName: 'cod_clasificacion',
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
	                                  return String.format('{0}', record.data['cod_clasificacion']);
	                           }
	                    },
	                    type: 'ComboBox',
	                    id_grupo: 0,
	                    filters: {pfiltro: 'cur.cod_clasificacion',type: 'string'},
	                    grid: false,
	                    form: true
	                    //,egrid:true,
	            },
                {
                    config: {
                        name: 'objetivo',
                        fieldLabel: 'Objetivo',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 1000
                    },
                    type: 'TextArea',
                    filters: {pfiltro: 'cur.objetivo', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                
                {
                    config: {
                        name: 'id_uo',
                        fieldLabel: 'Gerencia',
                        allowBlank: false,
                        emptyText: 'Unidad...',
                        blankText: 'Debe seleccionar una unidad',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_formacion/control/Planificacion/listarGerenciauo',
                            id: 'id_uo',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre_unidad',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_uo', 'nombre_unidad','cod_uo'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'nombre_unidad'}
                        }),
                        valueField: 'id_uo',
                        displayField: 'nombre_unidad',
                        gdisplayField: 'desc_uo',
                        hiddenName: 'id_uo',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 50,
                        minChars: 2,
                        gtpl: function (p){
                            	return this.desc_uo;
						}
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'desc_uo', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_unidad_organizacional',
                        fieldLabel: 'Unidad organizacional',
                        allowBlank: false,
                        emptyText: 'Unidad...',
                        blankText: 'Debe seleccionar una unidad',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_formacion/control/Planificacion/listarCargo',
                            id: 'id_cargo',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_cargo', 'nombre','cod_cargo'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'nombre'},
                            
                        }),
                        valueField: 'id_cargo',
                        displayField: 'nombre',
                        gdisplayField: 'unidad_organizacional',
                        hiddenName: 'id_unidad_organizacional',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 50,
                        minChars: 2,
                        gtpl: function (p){
                            return this.unidad_organizacional;
						}
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'unidad_organizacional', type: 'string'},
                    grid: true,
                    form: true
                },
                
                {
                    config: {
                        name: 'id_competencias',
                        fieldLabel: 'Competencias',
                        allowBlank: false,
                        emptyText: 'Competencias...',
                        blankText: 'Debe seleccionar una competencia',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_formacion/control/Competencia/listarCompetenciaCombo',
                            id: 'id_competencia',
                            root: 'datos',
                            sortInfo: {
                                field: 'competencia',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_competencia', 'competencia', 'tipo','cod_competencia','id_uo'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'competencia'}
                        }),
                        valueField: 'id_competencia',
                        displayField: 'competencia',
                        tpl: '<tpl for=".">  <div class="x-combo-list-item" >  <div class="awesomecombo-item {checked}"> <b>{tipo} </b> </div> <p>{competencia} </p> </div> </tpl>',
                        gdisplayField: 'desc_competencia',
                        hiddenName: 'id_competencias',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 150,
                        minChars: 2,
                        enableMultiSelect: true,
                        /*renderer: function (value, p, record) {
                            return String.format('{0}', (record.data['desc_competencia']) ? record.data['desc_competencia'] : '');                   
                        }*/
                    },
                    type: 'AwesomeCombo',
                    id_grupo: 0,
                    filters: {pfiltro: 'competencia', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_funcionarios',
                        fieldLabel: 'Funcionario',
                        allowBlank: false,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_formacion/control/Curso/listarFuncionarioCombos',
                            id: 'id_funcionario',	
                            root: 'datos',
                            sortInfo: {
                                field: 'desc_person',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_funcionario', 'codigo', 'desc_person', 'ci'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'FUNCIO.codigo#PERSON.nombre_completo2'}

                        }),
                        valueField: 'id_funcionario',
                        displayField: 'desc_person',
                        tpl: '<tpl for="."> <div class="x-combo-list-item" ><div class="awesomecombo-item {checked}">{codigo}</div> <p>{desc_person}</p> <p>CI:{ci}</p> </div></tpl>',
                        gdisplayField: 'desc_person',
                        hiddenName: 'id_funcionario',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 150,
                        minChars: 2,
                        enableMultiSelect: true,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['funcionarios']);
                        }
                    },
                    type: 'AwesomeCombo',
                    id_grupo: 0,
                    filters: {pfiltro: 'PERSON.desc_funcionario1', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'fecha_inicio',
                        fieldLabel: 'Fecha inicio',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'cur.fecha_inicio', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'fecha_fin',
                        fieldLabel: 'Fecha fin',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'cur.fecha_fin', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },

                {
                    config: {
                        name: 'id_lugar_pais',
                        fieldLabel: 'Pais',
                        allowBlank: false,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_parametros/control/Lugar/listarLugar',
                            id: 'id_',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_lugar', 'nombre', 'tipo'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'nombre', tipo: 'pais'}
                        }),
                        valueField: 'id_lugar', //srtore del combo
                        displayField: 'nombre', //estore del combo
                        gdisplayField: 'nombre_pais', //datos del store del grid
                        hiddenName: 'id_lugar_pais',// datos del store del grid
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 150,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['nombre_pais']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'lp.id_lugar_pais', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_lugar',
                        fieldLabel: 'Lugar',
                        allowBlank: true,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_formacion/control/Curso/listarPaisLugar',
                            id: 'id_lugar',
                            root: 'datos',
                            sortInfo: {
                                field: 'lug.nombre',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_lugar', 'nombre', 'tipo'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'lug.nombre',tipo:'pais'}
                        }),
                        valueField: 'id_lugar',
                        displayField: 'nombre',
                        gdisplayField: 'nombre',
                        hiddenName: 'id_lugar',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 150,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['nombre']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'lug.nombre', type: 'string'},
                    grid: true,
                    form: true
                },
	            {
	                    config: {
	                           name: 'origen',
	                           fieldLabel: 'Origen',
	                           allowBlank: false,
	                           emptyText: 'Elija una opción...',
	                           store: new Ext.data.ArrayStore({
			                        id: 0,
			                        fields: [
			                            'origen'
			                        ],
			                        data: [['Externo'], ['Interno'],['In Company']]
	                           }),
	                           valueField: 'origen',
	                           displayField: 'origen',
	                           gdisplayField: 'origen',
	                           hiddenName: 'origen',
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
	                                  return String.format('{0}', record.data['origen']);
	                           }
	                    },
	                    type: 'ComboBox',
	                    id_grupo: 0,
	                    filters: {pfiltro: 'cur.origen',type: 'string'},
	                    grid: false,
	                    form: true
	                    //,egrid:true,
	            },
                {
                    config: {
                        name: 'expositor',
                        fieldLabel: 'Expositor',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 50
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'cur.expositor', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_proveedor',
                        fieldLabel: 'Proveedor',
                        allowBlank: true,
                        emptyText: 'Proveedores...',
                        blankText: 'Debe seleccionar un proveedor',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_formacion/control/Curso/listarProveedorCombos',
                            id: 'id_proveedor',
                            root: 'datos',
                            sortInfo: {
                                field: 'desc_proveedor',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_proveedor', 'desc_proveedor','cod_proveedor'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'desc_proveedor'}
                        }),
                        valueField: 'id_proveedor',
                        displayField: 'desc_proveedor',
                        gdisplayField: 'desc_proveedor',
                        hiddenName: 'id_proveedor',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '80%',
                        gwidth: 150,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['desc_proveedor']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'desc_proveedor', type: 'string'},
                    grid: true,
                    form: true
                },                
	            {
	                    config: {
	                           name: 'evaluacion',
	                           fieldLabel: 'Evaluacion',
	                           allowBlank: false,
	                           emptyText: 'Elija una opción...',
	                           store: new Ext.data.ArrayStore({
			                        id: 0,
			                        fields: [
			                            'evaluacion'
			                        ],
			                        data: [['Si'], ['No']]
	                           }),
	                           valueField: 'evaluacion',
	                           displayField: 'evaluacion',
	                           gdisplayField: 'evaluacion',
	                           hiddenName: 'evaluacion',
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
	                           /*renderer : function(value, p, record) {
	                                  return "";
	                           }*/
	                           /*,listeners: {
								   'afterrender': function(combo){			  
		    							combo.setValue('NO');       
								  	}
								}*/
	                    },
	                    type: 'ComboBox',
	                    id_grupo: 0,
	                    filters: {pfiltro: 'scu.evaluacion',type: 'string'},
	                    grid: true,
	                    form: true
	                    //,egrid:true,
	            },
	            {
	                    config: {
	                           name: 'certificacion',
	                           fieldLabel: 'Certificacion',
	                           allowBlank: false,
	                           emptyText: 'Elija una opción...',
	                           store: new Ext.data.ArrayStore({
			                        id: 0,
			                        fields: [
			                            'certificacion'
			                        ],
			                        data: [['Si'], ['No']]
	                           }),
	                           valueField: 'certificacion',
	                           displayField: 'certificacion',
	                           gdisplayField: 'certificacion',
	                           hiddenName: 'certificacion',
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
	                                  return "";
	                           }
	                           ,listeners: {
								   'afterrender': function(combo){			  
		    							combo.setValue('NO');       
								  	}
								}
	                    },
	                    type: 'ComboBox',
	                    id_grupo: 0,
	                    filters: {pfiltro: 'scu.certificacion',type: 'string'},
	                    grid: true,
	                    form: true
	                    //,egrid:true,
	            },
                {
                    config: {
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'cur.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: '',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'cur.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'cur.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 300
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'cur.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu1.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu2.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'cur.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            tam_pag: 50,
            argumentSave: {},
            timeout: Phx.CP.config_ini.timeout,
    		conexionFailure: Phx.CP.conexionFailure,
            title: 'Curso',
            ActSave: '../../sis_formacion/control/Curso/insertarCurso',
            ActDel: '../../sis_formacion/control/Curso/eliminarCurso',
            ActList: '../../sis_formacion/control/Curso/listarCurso',
            id_store: 'id_curso',
            fields: [
                {name: 'id_curso', type: 'numeric'},
                {name: 'id_gestion', type: 'numeric'},
                {name: 'id_lugar', type: 'numeric'},
                {name: 'id_lugar_pais', type: 'numeric'},
                {name: 'id_proveedor', type: 'numeric'},
                {name: 'horas', type: 'numeric'},
                {name: 'cod_tipo', type: 'string'},
                {name: 'cod_prioridad', type: 'string'},
                {name: 'evaluacion', type: 'string'},
                {name: 'certificacion', type: 'string'},
                {name: 'cod_clasificacion', type: 'string'},
                {name: 'nombre_curso', type: 'string'},
                {name: 'expositor', type: 'string'},
                {name: 'origen', type: 'string'},
                {name: 'fecha_inicio', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'estado_reg', type: 'string'},
                {name: 'objetivo', type: 'string'},
                {name: 'contenido', type: 'string'},
                {name: 'fecha_fin', type: 'date', dateFormat: 'Y-m-d'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'gestion', type: 'string'},
                {name: 'nombre', type: 'string'},
                {name: 'nombre_pais', type: 'string'},
                {name: 'desc_proveedor', type: 'string'},
                {name: 'id_competencias', type: 'string'},
                {name: 'desc_competencia', type: 'string'},
                {name: 'id_planificacion', type: 'string'},
                {name: 'planificacion', type: 'string'},
                {name: 'id_funcionarios', type: 'string'},
                {name: 'funcionarios', type: 'string'},
                'id_uo',
                'desc_uo',
                'id_unidad_organizacional',
                'unidad_organizacional',
                {name: 'peso', type: 'numeric'},
            ],
            sortInfo: {
                field: 'id_curso',
                direction: 'ASC'
            },
            bdel: true,
            bsave: false,
	        onButtonNew: function() {
		       	//Phx.vista.Curso.superclass.onButtonNew.call(this);
		       
		       	if(!this.cmbGestion.getValue()){
		       	   	alert("Seleccione una gestion");
		       	}
		       	else{
			        this.window.buttons[0].show();
			        this.form.getForm().reset();
			        this.loadValoresIniciales();
			        this.window.show();
			        if(this.getValidComponente(0)){
			        	this.getValidComponente(0).focus(false,100);
			        }
		       	}


		    },
		    onButtonEdit: function() {
		    	
		        this.window.show();
		        this.loadForm(this.sm.getSelected())
		       
		        this.window.buttons[0].hide();
		        this.loadValoresIniciales();
		         
		    },
            loadValoresIniciales: function () {
                Phx.vista.Curso.superclass.loadValoresIniciales.call(this);

                this.getComponente('id_gestion').setValue(this.cmbGestion.getValue());           

            	this.Cmp.id_planificacion.store.setBaseParam('id_gestion', this.cmbGestion.getValue());
				this.Cmp.id_planificacion.modificado = true;
									                                             
            },
        }
    )
</script>