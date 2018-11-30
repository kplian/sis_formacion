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

    var arrayMeses = [];
    var v_id_gestion;
    
    Phx.vista.FormCursoAvanceReal = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
				this.maestro = config.maestro;
				this.initButtons = [this.cmbGestion];
				v_maestro = config.maestro;
				//llama al constructor de la clase padre
				Phx.vista.FormCursoAvanceReal.superclass.constructor.call(this, config);
				this.init();
				this.load({params: {start: 0, limit: this.tam_pag}})
				this.addButton('btnAvances', {
		            text: 'Avance real',
		            iconCls: 'blist',
		            disabled: false,
		            handler: this.AsignarAvance,
		            tooltip: '<b>Registro de los avances reales por meses</b>'
		        });	
						
				this.iniciarEventos();            
            },
            iniciarEventos: function () {
            	
                this.cmbGestion.on('select',
                       function (cmb, dat) {
                       	this.sm.clearSelections();
		                this.store.baseParams = {id_gestion: dat.data.id_gestion};
		                v_id_gestion=dat.data.id_gestion;
		                this.store.reload();
                }, this);
                
            },
		    AsignarAvance: function (record) {
		        this.GenerarColumnas('new', this);      
		    },
			GenerarColumnas: function (){
		    	Ext.Ajax.request({
					url: '../../sis_formacion/control/Curso/GenerarColumnaMeses',
					params: {
					    'id_gestion': v_id_gestion,
					},
					success: this.RespuestaColumnas,
					failure: this.conexionFailure,
					timeout: this.timeout,
					scope: this
				}); 
			},
			RespuestaColumnas: function (s,m){		
		        this.maestro = m;
		        var meses = s.responseText.split('%');
				arrayMeses = meses[1].split(",");
				this.openAvance();
			},
		    openAvance: function () {  	  
		    	       
				if (this.cmbGestion.getValue()) {        	        	
		        	var me = this; 
			        Phx.CP.loadingShow();
			    	me.objSolForm = Phx.CP.loadWindows('../../../sis_formacion/vista/curso/FormAvance.php',
			        'Formulario de Avance',
			        {
			            modal: true,
			            width: '80%',
			            height: '60%'
			        }, 
			        {
			            data: 
			            {
			                'id_gestion': v_id_gestion,
			                meses: arrayMeses
			            }
			        },
			        this.idContenedor,
			        'FormAvance',
			        );	
		        } else {
		        	alert('Seleccione una gestion');	
		        }
		    },
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
                    bottom_filter: true,
                    filters: {pfiltro: 'nombre_curso', type: 'string'},
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
                    bottom_filter: true,
                    filters: {pfiltro: 'horas', type: 'numeric'},
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
	                    bottom_filter: true,
	                    id_grupo: 0,
	                    filters: {pfiltro: 'cod_prioridad',type: 'string'},
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
                    bottom_filter: true,
                    filters: {pfiltro: 'peso', type: 'numeric'},
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
            ActSave: '../../sis_formacion/control/Curso/insertarCurso',
            ActDel: '../../sis_formacion/control/Curso/eliminarCurso',
            ActList: '../../sis_formacion/control/Curso/listarCurso',
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