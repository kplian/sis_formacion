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
var id_proveedor;
var id_curso;
var proveedor;
var curso;
var fecha;
Phx.vista.FormProveedorEva = Ext.extend(Phx.frmInterfaz,{
	
	constructor:function(config)
	{		
		this.config=config;	
		this.configMaestro=config;	
		Phx.CP.loadingShow();	
		id_proveedor=this.configMaestro.data.id_proveedor;
		id_curso=this.configMaestro.data.id_curso;	
		proveedor=this.configMaestro.data.proveedor;
		curso=this.configMaestro.data.curso;	
		fecha=this.configMaestro.data.fecha;		
		this.storeAtributos= new Ext.data.JsonStore({
			url:'../../sis_formacion/control/Preguntas/listarPreguntasPro',			
			id: 'id_pregunta',
			root: 'datos',				
			fields:  
			[
				'id_pregunta',
				{name:'tipo', type: 'string'},				
				{name:'pregunta', type: 'string'},
				{name:'habilitado', type: 'string'},
				{name:'seccion', type: 'string'},
				{name:'categoria', type: 'string'},
				{name:'tipocat', type: 'string'},			
			],
			sortInfo:{
				field: 'id_pregunta',
				direction: 'ASC'
			}	
		});	
		this.storeAtributos.on('loadexception',this.conexionFailure);				
		this.storeAtributos.load({
			params:
			{
				"sort":"id_pregunta",
				"dir":"ASC",
				start:0, 
				limit:500
			},
			callback:this.successConstructor,
			scope:this
		});		
	},
	//
	successConstructor:function(rec,con,res)
	{ 			
		//
		this.fields=[];
		this.Atributos=[];
		this.id_store='id_pregunta';	
		this.sortInfo=
		{
			field: 'id_pregunta',
			direction: 'ASC'
		};		
		this.fields.push(this.id_store)
		this.fields.push('id_pregunta')
		this.fields.push({name:'tipo', type: 'TextField'})
		this.fields.push({name:'pregunta', type: 'TextField'})
		this.fields.push({name:'habilitado', type: 'Boolean'})
		this.fields.push({name:'seccion', type: 'TextField'})
		this.fields.push({name:'pregunta', type: 'TextField'})
		this.fields.push({name:'categoria', type: 'TextField'})
		this.fields.push({name:'tipocat', type: 'TextField'})	
		//	
		//
		if(res){			
			var i=0;
			var cant = rec.length;
			this.Atributos[0]=
			{				
				config:
				{
					labelSeparator:'',
					inputType:'hidden',
					name: this.id_store
				},
				type:'Field'
			},			
			this.Atributos[1]=
			{
				config:{
					fieldLabel: 'Curso',
					disabled: true,
					value: curso,
					name:'curso'
				},
				type:'TextField'
			},
			this.Atributos[2]=
			{
				config:{
					fieldLabel: 'Proveedor',
					disabled: true,
					value: proveedor,
					name:'proveedor'
				},
				type:'TextField'
			}	
			//	
			this.Grupos = [{
				
			}];		
			console.log('*-*-',this);						
			//			
			while(i<cant) {	
				console.log('=>=>=>=> ',rec[i].data);
				switch (rec[i].data.tipo) {
					case 'Seleccion':																	
						this.fields.push(i.toString())
						this.Atributos.push({
							config:{
								labelSeparator:'',
								name: i.toString(),
								fieldLabel: rec[i].data.pregunta,
								queryMode:'local',
								store:['Muy Bueno','Bueno','Regular','Insuficiente'],
								autoSelect:true,
								forceSelection:true
							},
							type:'ComboBox'
						});		
					break;
					case 'Texto':							
						this.fields.push(i.toString())
						this.Atributos.push({
							config:{
								labelSeparator:'',
								name: i.toString(),
								fieldLabel: rec[i].data.pregunta
							},
							type:'Field'
						});					
					break;
					default:
						console.log('error');
					break;
				}					
				i++;
			}
			this.Atributos.push({
				config:{
					value:cant,
					name:'cant',
					fieldLabel: 'Cantidad',
					hidden:true
				},
				type:'Field'
			});		
			//
		}
		
		Phx.CP.loadingHide();
		Phx.vista.FormProveedorEva.superclass.constructor.call(this, this.config);
		this.init();
	},
	//
    onSubmit: function(o, x, force) {
		var me = this;
		if (me.form.getForm().isValid() || force===true) {
            Phx.CP.loadingShow();
            Ext.apply(me.argumentSave, o.argument);                     	
    		Ext.Ajax.request({
				url: '../../sis_formacion/control/Preguntas/insertarPreguntaPro',
				params: me.getValForm,
				success: me.successSave,
                argument: me.argumentSave,
                failure: me.conexionFailure,
                timeout: me.timeout,
                scope: me
			});		            				            			                     
		}		
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
	    console.log(resp);
	    return resp
	},  	
	//
	title: 'Formulario Funcionario',

	topBar: true,//barra de herramientas
	bottomBar: true,//barra de herramientas en la parte inferior
	botones: true,//Botones del formulario
	tipoInterfaz: 'frmInterfaz',		
	argumentSave: {},
	//
	bsubmit: true,
	breset: false,
	bcancel: false,
	borientacion: false,
	bformato: false,
	btamano: false,
	//
	tipo: 'proceso',
	mensajeExito: 'Proceso generado!',
	//Para los botones de la barra de herramientas
	labelSubmit: '<i class="fa fa-check"></i> Guardar',
	labelReset: '<i class="fa fa-times"></i> Reset',
	labelCancel: '<i class="fa fa-times"></i> Declinar',
	tooltipSubmit: '<b>Guardar</b>',
	tooltipReset: '<b>Reset</b>',
	tooltipCancel: '<b>Declinar</b>',
	iconSubmit: '../../../lib/imagenes/print.gif',
	iconReset: '../../../lib/imagenes/act.png',
	iconCancel: '../../../lib/imagenes/cancel.png',
	clsSubmit: 'bsave',
	clsReset:  'breload2',
	clsCancel: 'bcancel',
	
})
</script>