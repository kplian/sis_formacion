<?php
/**
 * @package pXP
 * @file gen-Planificacion.php
 * @author  (admin)
 * @date 26-04-2017 20:37:24
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
	var v_maestro = null;
    Phx.vista.Planificacion = Ext.extend(Phx.gridInterfaz, {
 
            constructor: function (config) {
                this.maestro = config.maestro; 
                this.initButtons = [this.cmbGestion];
                v_maestro = this.maestro;
                //llama al constructor de la clase padre
                Phx.vista.Planificacion.superclass.constructor.call(this, config);
                this.init();
                this.grid.addListener('cellclick', this.oncellclick,this);
                this.load({params: {start: 0, limit: this.tam_pag}})
                this.iniciarEventos();
                
				this.addButton('btnAprobado', {
	                text: 'Aprobar',
	                iconCls: 'block',
	                disabled: false,
	                handler: function () {
	                    this.aprobarPlanificacion(1)
	                },
	                tooltip: '<b>Aprobar</b>'
	            });
	
	            this.addButton('btnDesAprobado', {
	                text: 'Desaprobar',
	                iconCls: 'bunlock',
	                disabled: false,
	                handler: function () {
	                    this.aprobarPlanificacion(0)
	                },	
	                tooltip: '<b>Desaprobar</b>'
	            });
                this.getBoton('btnAprobado').hide();
                this.getBoton('btnDesAprobado').hide();
            },
	        aprobarPlanificacion: function (valorAprobado) {
	        	
	        	
	        	
	            var me = this; 	
	            if(valorAprobado==1){
	 		         this.getBoton('btnDesAprobado').show();
	 		         this.getBoton('btnAprobado').hide();
	 		     }
	 		     else{
	 		     	 this.getBoton('btnDesAprobado').hide();
	 		     	 this.getBoton('btnAprobado').show();
	 		     }
	            var me = this;
	            if (this.cmbGestion.getValue()) {
	            	Phx.CP.loadingShow();
	                Ext.Ajax.request({
	                    url: '../../sis_formacion/control/Planificacion/aprobarPlanificacion',
	                    params: {
	                        'id_planificacion': me.sm.selections.items[0].data.id_planificacion,
	                        'aprobado': valorAprobado,
	                        'transaccion':'SIGEFO_APROB_PLA',
	                        'id_usuario': Phx.CP.config_ini.id_usuario
	                    },
	                    success: me.successSaveAprobar,
	                    failure: me.conexionFailureAprobarPlanificacion,
	                    timeout: me.timeout,
	                    scope: me
	                });
	            }
	            else {
	                Ext.MessageBox.alert('ERROR!!!', 'Seleccione primero una gestion.');
	            }
                this.reload();
                
                
                
	        },
	        //
	        successSaveAprobar: function () {
	            Phx.CP.loadingHide();
	            Ext.MessageBox.alert('EXITO!!!', 'Se realizo con exito la operación.');
	        },  
	        conexionFailureAprobarPlanificacion: function () {
	        	var me = this; 	
	        	if(this.sm.selections.items[0].data.aprobado=='t'){
	        		 this.getBoton('btnDesAprobado').show();
	 		         this.getBoton('btnAprobado').hide();
	        	}
	        	else{
	        	     this.getBoton('btnDesAprobado').hide();
	 		     	 this.getBoton('btnAprobado').show();
	        	}
	            Phx.CP.loadingHide(); 		
	            this.reload();
	            alert('ALERTA!! Sr(a) Usuario no tiene permiso para aprobar la planificacion, contactese con el administrador')
	        },  
	        
	       	oncellclick : function(grid, rowIndex, columnIndex, e) {
		        var record = this.store.getAt(rowIndex),
		            fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name
		
		         //alert(record.data['aprobado']);
		         if(record.data['aprobado']=='t'){
	 		         this.getBoton('btnDesAprobado').show();
	 		         this.getBoton('btnAprobado').hide();
	 		     }
	 		     else{
	 		     	 this.getBoton('btnDesAprobado').hide();
	 		     	 this.getBoton('btnAprobado').show();
	 		     	 //this.getBoton('btnAprobado').disable();
	 		     }
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
            //
            onButtonDel:function(){	
            	if(confirm('¿Está seguro de eliminar el registro?')){
	            	var me = this;				
					Phx.CP.loadingShow();
					var filas=this.sm.getSelections();							
					Ext.Ajax.request({
						url: '../../sis_formacion/control/Planificacion/eliminarPlanificacion',
						success:this.successDel,
						failure:this.conexionFailure,
						params: 
						{						
	                        'id_planificacion': filas[0].id
	                    },
						//success: me.successSaveAprobar,
	                    //failure: me.conexionFailureAprobar,
	                    timeout: me.timeout,
	                    scope: me
					});	
				}	
			},
			//
			successDel:function(resp){
				Phx.CP.loadingHide();
				this.reload();			
			},
			// 
			conexionFailureAprobar: function () {
                Phx.CP.loadingHide();
                alert('Error no se pudo eliminar debido a alguan dependecia');
                this.reload();
            },
            //
            iniciarEventos: function () {

                this.cmbGestion.on('select',
                       function (cmb, dat) {
                       	//console.log("testear combo",dat.data.id_gestion);
                       	this.sm.clearSelections();
		                this.store.baseParams = {id_gestion: dat.data.id_gestion};
		                this.store.reload();
                }, this);
               
            },

            Atributos: [
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_planificacion'
                    },
                    type: 'Field',
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
                        name: 'nombre_planificacion',
                        fieldLabel: 'Nombre planificación',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 150
                    },
                    type: 'TextField',
                    bottom_filter: true,
                    filters: {pfiltro: 'sigefop.nombre_planificacion', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'contenido_basico',
                        fieldLabel: 'Contenido básico',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 5000
                    },
                    type: 'TextArea',
                    bottom_filter: true,
                    filters: {pfiltro: 'sigefop.contenido_basico', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'necesidad',
                        fieldLabel: 'Necesidad',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 5000
                    },
                    type: 'TextArea',
                    bottom_filter: true,
                    filters: {pfiltro: 'sigefop.necesidad', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'cantidad_personas',
                        fieldLabel: 'Cantidad personas',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'NumberField',
                    bottom_filter: true,
                    filters: {pfiltro: 'sigefop.cantidad_personas', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'horas_previstas',
                        fieldLabel: 'Horas previstas',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'NumberField',
                    bottom_filter: true,
                    filters: {pfiltro: 'sigefop.horas_previstas', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },

                {
                    config: {
                        name: 'cod_criterio',
                        fieldLabel: 'Criterios de evaluación',
                        allowBlank: true,
                        emptyText: 'Criterios...',
                        blankText: 'Debe seleccionar un criterio',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_parametros/control/Catalogo/listarCatalogoCombo',
                            id: 'codigo',
                            root: 'datos',
                            sortInfo: {
                                field: 'descripcion',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['codigo', 'descripcion'],
                            remoteSort: true,
                            baseParams: {
                                par_filtro: 'descripcion', cod_subsistema: 'SIGEFO',
                                catalogo_tipo: 'tplanificacion_critico'
                            }
                        }),
                        valueField: 'codigo',
                        displayField: 'descripcion',
                        gdisplayField: 'descripcion',
                        hiddenName: 'codigo',
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
                            return String.format('{0}', (record.data['desc_criterio']) ? record.data['desc_criterio'] : '');
                        }
                    },
                    type: 'AwesomeCombo',
                    id_grupo: 0,
                    filters: {pfiltro: 'descripcion', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_competencias',
                        fieldLabel: 'Competencia',
                        allowBlank: false,
                        emptyText: 'Competencias...',
                        blankText: 'Debe seleccionar una competencia',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_formacion/control/Competencia/listarCompetenciaCombo',
                            //id: 'id_competencia_nivel',
                            id: 'id_competencia',
                            root: 'datos',
                            sortInfo: {
                                field: 'desc_competencia',
                                //field: 'competencia_nivel',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_competencia', 'competencia', 'tipo','cod_competencia','id_uo','desc_competencia'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'competencia'}
                        }),
                        valueField: 'id_competencia',
                        displayField: 'desc_competencia',
                        //tpl: '<tpl for=".">  <div class="x-combo-list-item" >  <div class="awesomecombo-item {checked}"> <b>{tipo} </b> </div> <p>{competencia} </p> </div> </tpl>',
                        tpl: '<tpl for=".">  <div class="x-combo-list-item" >  <div class="awesomecombo-item {checked}"> <b>{tipo} </b> </div> <p>{desc_competencia} </p> </div> </tpl>',
                        gdisplayField: 'desc_competencia',
                        hiddenName: 'id_competencias',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 300,
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
                    filters: {pfiltro: 'c.competencia', type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_proveedor',
                        fieldLabel: 'proveedor',
                        allowBlank: true,
                        emptyText: 'proveedor...',
                        blankText: 'Debe seleccionar un proveedor',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_parametros/control/Proveedor/listarProveedorCombos',
                            id: 'id_proveedor',
                            root: 'datos',
                            sortInfo: {
                                field: 'desc_proveedor',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_proveedor', 'desc_proveedor'],
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
                        gwidth: 50,
                        minChars: 2,
                        gtpl: function (p){
                            return this.desc_proveedor;
						}
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'proveedor', type: 'string'},
                    grid: true,
                    form: true
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
                    filters: {pfiltro: 'sigefop.usuario_ai', type: 'string'},
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
                    grid: true,
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
                    filters: {pfiltro: 'sigefop.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'sigefop.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
                    form: false
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
                    filters: {pfiltro: 'sigefop.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
				{
					config:{
						name: 'aprobado',
						fieldLabel: 'Aprobado',
						allowBlank: true,
						anchor: '80%',
						gwidth: 100,
		                renderer: function (value, p, record, rowIndex, colIndex){
		                    if(record.data.aprobado =='t'){
		                        return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:37px;width:37px;" type="checkbox"  {0} {1}></div>','checked', 'disabled');
		                    }
		                    else{
		                        return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:37px;width:37px;" type="checkbox"  {0} {1}></div>','', 'disabled');
		                    }
		                }
					},
						type:'Checkbox',
						filters:{pfiltro:'sigefop.aprobado',type:'boolean'},
						id_grupo:1,
						grid:true,
						form:false
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
                    filters: {pfiltro: 'sigefop.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
            ],
            tam_pag: 300,
            title: 'Planificación',
            ActSave: '../../sis_formacion/control/Planificacion/insertarPlanificacion',
            ActDel: '../../sis_formacion/control/Planificacion/eliminarPlanificacion',
            ActList: '../../sis_formacion/control/Planificacion/listarPlanificacion',
            id_store: 'id_planificacion',
            fields: [
                {name: 'id_planificacion', type: 'numeric'},
                {name: 'id_gestion', type: 'numeric'},
                {name: 'estado_reg', type: 'string'},
                {name: 'cantidad_personas', type: 'numeric'},
                {name: 'contenido_basico', type: 'string'},
                {name: 'nombre_planificacion', type: 'string'},
                {name: 'necesidad', type: 'string'},
                {name: 'horas_previstas', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'gestion', type: 'string'},
                'cod_criterio',
                'desc_criterio',
                'id_competencias',
                'desc_competencia',
                'id_proveedor',
                'desc_proveedor',
                {name: 'aprobado', type: 'string'},
            ],            
            sortInfo: {
                field: 'id_planificacion',
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
			        //this.Cmp.aprobado.setValue(false);
		       	}


		    },
            onButtonEdit: function () {
                Phx.vista.Planificacion.superclass.onButtonEdit.call(this);                
		        /*if(this.sm.selections.items[0].data.aprobado=='t'){
		        	this.Cmp.aprobado.setValue(true);
		        }
		        else{
		        	this.Cmp.aprobado.setValue(false);
		        }*/
            },
            loadValoresIniciales: function () {
                Phx.vista.Planificacion.superclass.loadValoresIniciales.call(this);
                this.getComponente('id_gestion').setValue(this.cmbGestion.getValue());   
                    				                                             
            },
        }
    )
</script>
		
		