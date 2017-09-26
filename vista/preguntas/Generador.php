<?php
/**
*@package pXP
*@file gen-Preguntas.php
*@author  (manu)
*@date 20-04-2017 00:51:06
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script> 
Phx.vista.Generador = Ext.extend(Phx.frmInterfaz,{
	
		constructor : function(config) {
			Phx.vista.Generador.superclass.constructor.call(this, config);
			this.init();
			this.Cmp.id_curso.reset();
			this.Cmp.id_curso.allowBlank = true;		
			this.mostrarComponente(this.Cmp.id_curso);	
			this.Cmp.id_proveedor.reset();
			this.Cmp.id_proveedor.allowBlank = true;		
			this.mostrarComponente(this.Cmp.id_proveedor);	
                
			this.addButton('btnAvances', { 
	            text: 'Formulario',
	            iconCls: 'block',
	            disabled: false,
	            handler: this.AsignarAvance,
	            tooltip: '<b>Formulario</b>'
	        });						
		},
		//
		AsignarAvance: function (record) {
			this.Cuestionario('new', this);      
		},
		//
		Cuestionario: function () {  	  	              	        	
			var me = this; 	
			//console.log(this.Cmp);	
			if(this.Cmp.id_proveedor.getValue() && this.Cmp.id_curso.getValue() && this.Cmp.fecha.getValue()){				
				Phx.CP.loadingShow();
				me.objSolForm = Phx.CP.loadWindows('../../../sis_formacion/vista/preguntas/FormProveedorEva.php',
					'Cuestionario-Funcionario',
					{
						modal: true,
						width: '30%',
						frame: true,
						border: true
					}, 
					{
						data: 
						{
							'id_proveedor': this.Cmp.id_proveedor.getValue(),
							'proveedor': this.Cmp.id_proveedor.lastSelectionText,
	                		'id_curso': this.Cmp.id_curso.getValue(),
	                		'curso': this.Cmp.id_curso.lastSelectionText,
	                		'fecha': this.Cmp.fecha.getValue()
						}
					},
					this.idContenedor,
					'FormProveedorEva',
				);
			}
			else {
				alert('Ingrese todos los datos requeridos');
			}
			this.Cmp.id_proveedor.reset();	
			this.Cmp.id_curso.reset();
			this.Cmp.fecha.reset();	
		}, 		
		//
		Atributos : [
			{
	            config: {
	                name: 'id_curso',
	                fieldLabel: 'Curso',
	                allowBlank: false,
	                emptyText: '...',
	                store: new Ext.data.JsonStore({
	                    url: '../../sis_formacion/control/Curso/listarCurso',
	                    id: 'id_curso',
	                    root: 'datos',
	                    sortInfo: {
	                        field: 'nombre_curso',
	                        direction: 'ASC'
	                    },
	                    totalProperty: 'total',
	                    fields: ['id_curso', 'nombre_curso'],
	                    remoteSort: true,
	                    //baseParams: {tipo_usuario : 'todos',par_filtro: 'suc.nombre#suc.codigo'}
	                }),
	                valueField: 'id_curso',
	                gdisplayField : 'nombre_curso',
	                displayField: 'nombre_curso',                
	                hiddenName: 'id_curso',	                
	                forceSelection: true,
	                typeAhead: false,
	                triggerAction: 'all',
	                lazyRender: true,
	                mode: 'remote',
	                pageSize: 15,
	                width:250,
	                queryDelay: 1000,                
	                minChars: 2,
	                resizable:true,
	                hidden : true
	            },
	            type: 'ComboBox',
	            id_grupo: 0,            
	            form: true
	        },
	        {
	            config: {
	                name: 'id_proveedor',
	                fieldLabel: 'Proveedor',
	                allowBlank: false,
	                emptyText: '...',
	                store: new Ext.data.JsonStore({
	                    url: '../../sis_parametros/control/Proveedor/listarProveedor',
	                    id: 'id_proveedor',
	                    root: 'datos',
	                    sortInfo: {
	                        field: 'nombre',
	                        direction: 'ASC'
	                    },
	                    totalProperty: 'total',
	                    fields: ['id_proveedor', 'nombre'],
	                    remoteSort: true,
	                    //baseParams: {tipo_usuario : 'todos',par_filtro: 'suc.nombre#suc.codigo'}
	                }),
	                valueField: 'id_proveedor',
	                gdisplayField : 'nombre',
	                displayField: 'nombre',                
	                hiddenName: 'id_proveedor',	                
	                forceSelection: true,
	                typeAhead: false,
	                triggerAction: 'all',
	                lazyRender: true,
	                mode: 'remote',
	                pageSize: 15,
	                width:250,
	                queryDelay: 1000,                
	                minChars: 2,
	                resizable:true,
	                hidden : true
	            },
	            type: 'ComboBox',
	            id_grupo: 0,            
	            form: true
	        },   
	        {
				config:{
					name: 'fecha',
					fieldLabel: 'Fecha',
					allowBlank: false,				
					format: 'd/m/Y'
				},
				type:'DateField',				
				id_grupo:0,				
				form:true
			}
		],
		title : 'Generar',
		//ActSave : '../../sis_ventas_facturacion/control/ReportesVentas/reporteResumenVentasBoa',
		topBar : true,
		bsubmit:false,
		breset: false,
		bcancel: false,
		botones : false
	
})
</script>