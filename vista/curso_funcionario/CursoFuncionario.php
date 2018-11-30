<?php
/**
*@package pXP
*@file gen-CursoFuncionario.php
*@author  (admin)
*@date 26-01-2017 16:26:09
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
	issue			fecha				autor					descripcion
 * #1				01/11/2018			EGS						se aumento campos para saber si o no se respondio el cuestionario de evaluacion del curso segun el curso y funcionario especificado
 * */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
var v_curso='';
var v_fechaInicio='';
var v_fechaFin='';
var v_id_gestion='';
Phx.vista.CursoFuncionario=Ext.extend(Phx.gridInterfaz,{
 
	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.CursoFuncionario.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
		this.addButton('btnVerEvaluacionFuncionario', {
            text: 'Ver evaluación',
            iconCls: 'bchecklist',
            disabled: false,
            handler: this.VerEvaluacionFuncionario,
            tooltip: '<b>Ver respuestas del funcionario</b>'
        });	
		this.addButton('btnLimpiarEvaluacionFuncionario', {
            text: 'Limpiar evaluación funcionario',
            iconCls: 'x-btn-text bcancelfile',
            disabled: false,
            handler: this.LimpiarEvaluacionFuncionario,
            tooltip: '<b>Limpiar cuestionario del funcionario seleccionado</b>'
        });	
	},
	
    onReloadPage: function (m) {     
       this.maestro = m;
       this.store.baseParams = {id_curso: this.maestro.id_curso};
       this.load({params: {start: 0, limit: 50}})
	   
	   v_curso=this.maestro.nombre_curso;
	   v_fechaInicio=this.maestro.fecha_inicio;
	   v_fechaFin=this.maestro.fecha_fin;
	   v_id_gestion=this.maestro.id_gestion;
       //console.log("ver id del curso ", this.maestro.id_curso);

     },
     VerEvaluacionFuncionario: function (record) {
        this.verPreguntasFuncionario('new', this);     
        //this.openForm('new');   
        
    },
    LimpiarEvaluacionFuncionario: function(){
    	var me = this; 	
    	if(me.sm.selections.items.length==1){	
	    		var id_curso=me.sm.selections.items[0].data.id_curso;
	    		var id_funcionario=me.sm.selections.items[0].data.id_funcionario;
	    		if(confirm('¿Está seguro de limpiar el cuestionario?')){
		    			Phx.CP.loadingShow();
		                Ext.Ajax.request({
		                    url: '../../sis_formacion/control/CursoFuncionario/limpiarCuestionario',
		                    params: {
		                        'id_curso': id_curso,
		                        'id_funcionario': id_funcionario
		                    },
		                    success: me.successSaveLimpiarCuestionario,
		                    failure: me.conexionFailureAprobar,
		                    timeout: me.timeout,
		                    scope: me
		                });
		                Phx.CP.loadingHide();
		    	}
    	}
    	else{
    		   alert('Seleccione un funcionario para limpiar las respuestas del cuestionario');
    	}
    },
    successSaveLimpiarCuestionario:function(){
    	 Phx.CP.loadingHide();
    	 Ext.MessageBox.alert('EXITO!!!', 'Se realizo con exito la operación');
    },
	verPreguntasFuncionario: function () {  	  	              	        	
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
                		'curso': v_curso,
                		'fecha_inicio': v_fechaInicio,
                		'fecha_fin': v_fechaFin,
                		'id_gestion':v_id_gestion,
                		'id_usuario': me.sm.selections.items[0].data.id_usuario,
                		'usuario': me.sm.selections.items[0].data.desc_person,
                		'id_proveedor': me.sm.selections.items[0].data.id_proveedor,
                		'tipo':'Funcionario',
                		'verBotonGuardar':'No'
					}
				},
				this.idContenedor,
				//'FormProveedorEva',
				'FormFuncionarioEva',
			);
		}
		else {
			alert('Seleccione un funcionario para ver las respuestas del cuestionario');
		}

	 }, 	
     loadValoresIniciales: function () {
    	//detalle
       Phx.vista.CursoFuncionario.superclass.loadValoresIniciales.call(this);
        //
       this.Cmp.id_curso.setValue(this.maestro.id_curso);

    },	
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_curso_funcionario'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_usuario'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'desc_person'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_curso'
			},
			type:'Field',
			form:true 
		}, 
   	    {
			config: {
				//enviar erreglo
				name: 'id_funcionarios',
				fieldLabel: 'Funcionario',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				       				store: new Ext.data.JsonStore({
				    					url: '../../sis_organigrama/control/Funcionario/listarFuncionario',
				    					id: 'id_funcionario',
				    					root: 'datos',
				    					sortInfo:{
				    						field: 'desc_person',
				    						direction: 'ASC'
				    					},
				    					totalProperty: 'total',
				    					fields: ['id_funcionario','codigo','desc_person','ci','documento','telefono','celular','correo'],
				      					// turn on remote sorting
				    					remoteSort: true,
				    					baseParams: {par_filtro: 'FUNCIO.codigo#PERSON.nombre_completo2'}

				    				}),
				valueField: 'id_funcionario',
				displayField: 'desc_person',
				tpl:'<tpl for="."> <div class="x-combo-list-item" ><div class="awesomecombo-item {checked}">{codigo}</div> <p>{desc_person}</p> <p>CI:{ci}</p> </div></tpl>',
				gdisplayField: 'desc_person',
				hiddenName: 'id_funcionario',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 150,
				minChars: 2,
				//para multiples
				enableMultiSelect: true,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_person']);
				}
			},
			//cambair el tipo de combo
			type: 'AwesomeCombo',
			//bottom_filter: true,
			id_grupo: 0,
			filters: {pfiltro: 'PERSON.desc_person',type: 'string'},
			grid: true,
			form: true
		},
		//#1				01/11/2018			EGS	
		{
			config:{
				name: 'evaluo',
				fieldLabel: 'Respondio ',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		//#1				01/11/2018			EGS	
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'cufu.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'cufu.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'cufu.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'cufu.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'cufu.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		//#1				01/11/2018			EGS	
		{
			config:{
				name: 'nro_respuesta',
				fieldLabel: 'Respuestas',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'.cuenta',type:'string'},
				id_grupo:1,
				grid:false,
				form:false
		},
		//#1				01/11/2018			EGS	
	],
	tam_pag:50,	
	title:'Curso funcionario',
	ActSave:'../../sis_formacion/control/CursoFuncionario/insertarCursoFuncionario',
	ActDel:'../../sis_formacion/control/CursoFuncionario/eliminarCursoFuncionario',
	ActList:'../../sis_formacion/control/CursoFuncionario/listarCursoFuncionario',
	id_store:'id_curso_funcionario',
	fields: [
		{name:'id_curso_funcionario', type: 'numeric'},
		{name:'id_curso', type: 'numeric'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_person', type: 'string'},
		{name:'codigo', type: 'string'},
		{name:'id_usuario', type: 'string'},
		
		{name:'nro_respuesta', type: 'numeric'},//#1				01/11/2018			EGS	
		{name:'evaluo', type: 'string'},//#1				01/11/2018			EGS	
		
	],
	sortInfo:{
		field: 'id_curso_funcionario',
		direction: 'ASC'
	},
	bdel:false,
	bsave:false,
	bedit:false,
	bnew:false,
	}
)
</script>
		
		