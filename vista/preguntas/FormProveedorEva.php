<?php
/**
 * @package pXP
 * @file gen-Curso.php
 * @author  (manu)
 * @date 23-01-2017 13:34:58
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
var col_generado='';

Phx.vista.FormProveedorEva= Ext.extend(Phx.gridInterfaz, {
		
	constructor:function(config)
	{
		this.configMaestro=config;
		this.config=config;
                    		
		Phx.CP.loadingShow();	
		this.storeAtributos= new Ext.data.JsonStore({	
			url:'../../sis_formacion/control/Curso/listarPreguntas',	//llamamos a la misma lista de cursos 		
			id: 'id_temporal',
			root: 'datos',			
			totalProperty: 'total',
			fields: 
			[
				'id_temporal',
				{name:'id_pregunta', type: 'string'},				
				{name:'pregunta', type: 'numeric'},
				{name:'respuesta', type: 'varchar'},
				{name:'tipo', type: 'varchar'},
				{name:'nivel', type: 'numeric'},
				{name:'id_usuario_reg', type: 'numeric'},			
			],
			
			sortInfo:{
				field: 'id_temporal',
				direction: 'ASC'
			}
		});
		this.storeAtributos.on('loadexception',this.conexionFailure);				
		this.storeAtributos.load({
			params:
			{
				"sort":"id_temporal",
	  			"dir":"ASC",
				start:0, 
			   	limit:500,
			   	'id_gestion': this.configMaestro.data.id_gestion,
			   	'tipo': this.configMaestro.data.tipo
			},callback:this.successConstructor,scope:this
		      
		})		
		

		
	},
	//
	successConstructor:function(rec,con,res)
	{ 

		this.recColumnas = rec;
		this.Atributos=[];
		this.fields=[];
		this.id_store='id_temporal';	
		this.sortInfo=
		{
			field: 'id_temporal',
			direction: 'ASC'
		};		
		
		this.fields.push(this.id_store)
		this.fields.push('id_temporal')
		this.fields.push('id_pregunta')
		this.fields.push({name:'pregunta', type: 'TextField'})
		this.fields.push({name:'respuesta', type: 'TextField'})
		this.fields.push({name:'tipo', type: 'TextField'})
        this.fields.push({name:'nivel', type: 'TextField'})
        this.fields.push({name:'id_usuario_reg', type: 'TextField'})

		if(res)
		{

			this.Atributos[0]={
			//configuracion del componente
								config:{
										labelSeparator:'',
										inputType:'hidden',
										name: this.id_store
								},
								type:'Field',
								form:true 
						};
			this.Atributos[1]={
			//configuracion del componente
								config:{
										labelSeparator:'',
										inputType:'hidden',
										name: this.id_temporal
								},
								type:'Field',
								form:true 
						};
			this.Atributos[2]={
			//configuracion del componente
								config:{
										labelSeparator:'',
										inputType:'hidden',
										name: this.id_pregunta
								},
								type:'Field',
								form:true 
						};
			this.Atributos[3]={
			//configuracion del componente
								config:{
	                                    name: 'pregunta',
										fieldLabel: 'Preguntas',
										allowBlank: false,
										//anchor: '80%',
						                renderer: function (value, p, record, rowIndex, colIndex){
						
						                   var espacion_blanco="";
						                   var duplicar="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						                   var nivel = record.data.nivel==null?0:record.data.nivel;
						                   var espacion_blanco = duplicar.repeat(nivel);
						
						                  
						                   if(record.data.nivel ==1){
						                   	    //p.style="background-color:#F9E4C4; text-aling:left";
						                   	    return  String.format('<div style="vertical-align:middle;text-align:left;"> '+''+' <img src="../../../lib/imagenes/a_form_edit.png"> '+ record.data.pregunta+' </div>');
						                   }
						                   else{
						                   	    return  String.format('<div style="vertical-align:middle;text-align:left;"> '+espacion_blanco+' <img src="../../../lib/imagenes/a_form.png"> '+ record.data.pregunta+' </div>');
						                   }
						                },
										anchor: '80%',
										gwidth: 500,
								},
								type:'TextField',
								filters:{pfiltro:'pregunta',type:'string'},
								grid:true,
								form:true
						};
						
			this.Atributos[4]={
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
	                                  return String.format('{0}', record.data['respuesta']);
	                           }
	                    },
	                    type: 'ComboBox',
	                    id_grupo: 0,
	                    filters: {pfiltro: 'respuesta',type: 'string'},
	                    grid: true,
	                    form: true,
	                    egrid:true
						};
						
			this.Atributos[5]={
								config:{
	                                    name: 'tipo',
										fieldLabel: 'tipo',
										allowBlank: false,
										anchor: '80%',
								},
								type:'TextField',
								filters:{pfiltro:'tipo',type:'string'},
								grid:true,
								form:true
						};
			this.Atributos[6]={
			//configuracion del componente
								config:{
										labelSeparator:'',
										inputType:'hidden',
										name: this.nivel
								},
								type:'Field',
								form:true 
						};
			this.Atributos[7]={
			//configuracion del componente
								config:{
										labelSeparator:'',
										inputType:'hidden',
										name: this.id_usuario_reg
								},
								type:'Field',
								form:true 
						};


		}	

        for (var i=0;i<rec.length;i++){
            console.log('ver preguntas ',rec[i]);	
        }
		
	        
		Phx.CP.loadingHide();
		this.initButtons = [this.contenidoImagen];
		Phx.vista.FormProveedorEva.superclass.constructor.call(this, this.config);
		this.argumentExtraSubmit={'datos': col_generado};
		this.init();
        this.store.baseParams={'id_gestion': this.configMaestro.data.id_gestion , 'datos': this.configMaestro.data.id_gestion,'tipo': this.configMaestro.data.tipo};			               
		this.load();	
		this.CargarEncabezado();	   

	},	
    contenidoImagen: new Ext.form.FormPanel({
     name: 'encabezado',
     id:'encabezado'
     //inputType: 'hidden',
    }),
    CargarEncabezado:function(){
    	var encab='<br><div style="margin: 0 auto;  width: 400px; padding: 1em; border: 1px solid #CCC; border-radius: 1em;">';
    	var encab=encab+'<div> <label for="name"><b>NOMBRE CURSO &nbsp;:</b></label> <label for="name">'+this.configMaestro.data.curso+'</label> </div>';
    	var encab=encab+'<div> <label for="name"><b>FECHA INICIO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :<b> </label><label for="name">'+this.configMaestro.data.fecha_inicio+'</label> </div>';
    	var encab=encab+'<div> <label for="name"><b>FECHA FIN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b></label> <label for="name">'+this.configMaestro.data.fecha_fin+'</label> </div>';
    	var encab=encab+'<div> <label for="name"><b>FUNCIONARIO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b></label> <label for="name">'+this.configMaestro.data.usuario+'</label> </div>  </div><br>';
    	document.getElementById("encabezado").innerHTML = encab;
    	//alert(Phx.CP.config_ini.id_usuario);
    },

	tam_pag:500,	
	title:'Avance Real',
	ActSave:'../../sis_formacion/control/Curso/insertarAvanceReal',
	//ActList:'../../sis_formacion/control/Curso/listarCursoAvanceDinamico',
	ActList:'../../sis_formacion/control/Curso/listarPreguntas',
	bdel:false,
	bsave:true, 
	bedit:false, 
	bnew:false,
})
</script>
		
		