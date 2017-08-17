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

    var v_id_gestion;
    
    Phx.vista.Generador = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
				this.maestro = config.maestro;
				this.initButtons = [this.cmbGestion];
				v_maestro = config.maestro;
				//llama al constructor de la clase padre
				Phx.vista.Generador.superclass.constructor.call(this, config);
				
				this.init();
				this.load({params: {start: 0, limit: this.tam_pag}})
				this.addButton('btnAvances', {
		            text: 'Responder cuestionario',
		            iconCls: 'bchecklist',
		            disabled: false,
		            handler: this.EvaluarFuncionario,
		            tooltip: '<b>Este cuestionario esta habilitado unicamente para funcionarios que tomarón algún curso</b>'
		        });	
						
				this.iniciarEventos();            
            },
            iniciarEventos: function () {
            	
            	this.store.baseParams = {id_usuario: Phx.CP.config_ini.id_usuario};
            	this.load({params: {start: 0, limit: this.tam_pag}})
            	
                this.cmbGestion.on('select',
                       function (cmb, dat) {
                       	this.sm.clearSelections();
		                this.store.baseParams = {id_gestion: dat.data.id_gestion, id_usuario: Phx.CP.config_ini.id_usuario};
		                v_id_gestion=dat.data.id_gestion;
		                this.store.reload();
                }, this);
                
            },
		    EvaluarFuncionario: function (record) {
		        this.GenerarPreguntas('new', this);     
		        //this.openForm('new');   
		        
		    },
			GenerarPreguntas: function () {  	  	              	        	
				var me = this; 	
				console.log(me.sm.selections.items.length);	
				if(me.sm.selections.items.length==1){				
					Phx.CP.loadingShow();
					//me.objSolForm = Phx.CP.loadWindows('../../../sis_formacion/vista/preguntas/FormProveedorEva.php',
					me.objSolForm = Phx.CP.loadWindows('../../../sis_formacion/vista/preguntas/FormFuncionarioEva.php',
						'Cuestionario-Funcionario',
						{
							modal: true,
							width: '70%',
							frame: true,
							border: true
						}, 
						{
							data: 
							{
		                		'id_curso': me.sm.selections.items[0].data.id_curso,
		                		'curso': me.sm.selections.items[0].data.nombre_curso,
		                		'fecha_inicio': me.sm.selections.items[0].data.fecha_inicio,
		                		'fecha_fin': me.sm.selections.items[0].data.fecha_fin,
		                		'id_gestion':me.sm.selections.items[0].data.id_gestion,
		                		'id_usuario': Phx.CP.config_ini.id_usuario,
		                		'usuario': me.sm.selections.items[0].data.funcionario_eval,
		                		//'tipo':'Proveedor'
		                		'tipo':'Funcionario'
							}
						},
						this.idContenedor,
						//'FormProveedorEva',
						'FormFuncionarioEva',
					);
				}
				else {
					alert('Seleccione un curso para evaluar');
				}

			}, 	
            /*openForm: function (tipo, record) {
                var me = this;
                me.objSolForm = Phx.CP.loadWindows('../../../sis_formacion/vista/preguntas/FormFuncionarioEva.php',
                    'Formulario de seguimiento de proyecto totales',
                    {
                        modal: true,
                        width: '50%',
                        height: '60%'
                    }, {
                        data: {
                            objPadre: me.maestro,
                            tipo_form: tipo,
                            datos_originales: record,
                                id_curso: me.sm.selections.items[0].data.id_curso,
		                		curso: me.sm.selections.items[0].data.nombre_curso,
		                		fecha_inicio: me.sm.selections.items[0].data.fecha_inicio,
		                		fecha_fin: me.sm.selections.items[0].data.fecha_fin,
		                		id_gestion:me.sm.selections.items[0].data.id_gestion,
		                		id_usuario: null,
		                		usuario: 'Admin',
		                		tipo:'Funcionario'                        }
                    },
                    this.idContenedor,
                    'FormFuncionarioEva',
                    {
                        config: [{
                            event: 'successsaveformulario',
                            delegate: this.onSaveForm,
                        }],
                        scope: me
                    });
            }, 
            onSaveForm: function (interface, valores, id_def_proyecto) {
                alert('Cuestionario guardado');
                interface.panel.close();
           }, */
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


	        onReloadPage: function (m) {
	           this.maestro = m;
	           console.log('maestro:',this.maestro);        
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
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_funcionario'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'fecha_inicio'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'fecha_fin'
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
                        fieldLabel: 'funcionario_eval',
                        inputType: 'hidden',
                        name: 'funcionario'
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
                
            ],
            tam_pag: 50,
            argumentSave: {},
            timeout: Phx.CP.config_ini.timeout,
    		conexionFailure: Phx.CP.conexionFailure,
            title: 'Curso',
            //ActSave: '../../sis_formacion/control/Curso/insertarCurso',
            //ActDel: '../../sis_formacion/control/Curso/eliminarCurso',
            ActList: '../../sis_formacion/control/Curso/listarCursoEvaluacion',
            id_store: 'id_curso',
            fields: [
                {name: 'id_curso', type: 'numeric'},
                {name: 'nombre_curso', type: 'string'},
                {name: 'id_gestion', type: 'numeric'},
                {name: 'cod_prioridad', type: 'string'},
                {name: 'horas', type: 'numeric'},
                'cantidad_personas',
                {name: 'peso', type: 'numeric'},
                {name: 'gestion', type: 'string'},
                {name: 'fecha_inicio', type: 'string'},
                {name: 'fecha_fin', type: 'string'},
                {name: 'funcionario_eval', type: 'string'},
                {name: 'id_funcionario', type: 'numeric'},
                
            ],
            sortInfo: {
                field: 'id_curso',
                direction: 'ASC'
            },
            bdel: true,
            bsave: false,
            bdel: false,
            bnew: false,
            bedit: false,
        }
    )
</script>