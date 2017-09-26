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
var v_padre=undefined;
var meses=null;
var gestion;
var arrayMeses=[];
var col_generado='';
var sum=0; 
Phx.vista.FormAvance= Ext.extend(Phx.gridInterfaz, {
		
	constructor:function(config)
	{
		this.configMaestro=config;
		this.config=config;
		v_id_correlativo =this.configMaestro.data.id_correlativo;
	    arrayMeses=this.configMaestro.data.meses;
	    gestion=this.configMaestro.data.id_gestion;
		Phx.CP.loadingShow();	
		this.storeAtributos= new Ext.data.JsonStore({
			url:'../../sis_formacion/control/Curso/listarCursoAvanceDinamico',			
			id: 'id_correlativo',
			root: 'datos',			
			totalProperty: 'total',
			fields: 
			[
				'id_correlativo',
				{name:'nombre_unidad_temp', type: 'string'},				
				{name:'nombre_curso_temp', type: 'string'},
				{name:'cod_prioridad_temp', type: 'string'},
				{name:'tipo_nodo_temp', type: 'string'},
				{name:'id_correlativo_key', type: 'numeric'},
				{name:'peso_temp', type: 'numeric'}			
			],
			sortInfo:{
				field: 'id_correlativo',
				direction: 'ASC'
			}
		});
		this.storeAtributos.on('loadexception',this.conexionFailure);				
		this.storeAtributos.load({
			params:
			{
				'id_gestion': gestion,
				"sort":"id_correlativo",
	  			"dir":"ASC",
				start:0, 
			   	limit:500
			},callback:this.successConstructor,scope:this
		})		
	},
	//
	successConstructor:function(rec,con,res)
	{ 
		this.recColumnas = rec;
		this.Atributos=[];
		this.fields=[];
		this.id_store='id_correlativo';	
		this.sortInfo=
		{
			field: 'id_correlativo',
			direction: 'ASC'
		};		
		this.fields.push(this.id_store)
		this.fields.push('id_correlativo')
		this.fields.push({name:'nombre_unidad_temp', type: 'TextField'})
		this.fields.push({name:'nombre_curso_temp', type: 'TextField'})
		this.fields.push('cod_prioridad_temp')
		this.fields.push('tipo_nodo_temp')
		this.fields.push('id_correlativo_key')
		this.fields.push('peso_temp')
				
		if(res)
		{
			this.Atributos[0]=
			{
				config:
				{
					labelSeparator:'',
					inputType:'hidden',
					name: this.id_store
				},
				type:'Field',
				form:true 
			};
			this.Atributos[1]=
			{
				config:{
					labelSeparator:'',
					inputType:'hidden',
					name: this.id_correlativo
				},
				type:'Field',
				form:true 
			};
			this.Atributos[2]=
			{
				config:{							
					name: 'nombre_unidad_temp',
					fieldLabel: 'Unidad Organizacional',
					allowBlank: false,
					anchor: '80%',
					gwidth: 230,
                	maxLength: 150,
                	renderer: function (value, p, record, rowIndex, colIndex){
                		var espacio="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";		                						
						if(record.data.cod_prioridad_temp == '-'){							
							return  String.format('<div style="vertical-align:middle;text-align:left;"> '+' <img src="../../../lib/imagenes/a_form_edit.png"> '+ record.data.nombre_unidad_temp+' </div>');
						}
						else{
							return  String.format('<div style="vertical-align:middle;text-align:left;"> '+espacio+espacio+' <img src="../../../lib/imagenes/a_form.png"> '+ record.data.nombre_unidad_temp+' </div>');
						} 
	                } 	                
				},
				type:'TextField',
				filters:{pfiltro:'nombre_unidad_temp',type:'string'},
				grid:true,
				form:true 
			};
			this.Atributos[3]=
			{
				config:{							
					name: 'cod_prioridad_temp',
					fieldLabel: 'Prioridad',
					allowBlank: false,
					anchor: '80%',
					gwidth: 70,
	                maxLength: 150,
	                renderer: function (value, p, record, rowIndex, colIndex){		                						
						if(record.data.cod_prioridad_temp == '0'){
							return  String.format('<div style="vertical-align:middle;text-align:left;"> '+'-' + ' </div>');
						}
						else{
							return  String.format('<div style="vertical-align:middle;text-align:left;"> '+ record.data.cod_prioridad_temp +' </div>');
						} 
	                }                 
				},
				type:'TextField',
				filters:{pfiltro:'cod_prioridad_temp',type:'string'},
				grid:true,
				form:true 
			};
			this.Atributos[4]=
			{
				config:{							
					name: 'peso_temp',
					fieldLabel: 'Peso',
					allowBlank: false,
					anchor: '80%',
					gwidth: 50,
	                maxLength: 150,
	                renderer: function (value, p, record, rowIndex, colIndex){		                						
						if(record.data.peso_temp == '0.00'){
							return  String.format('<div style="vertical-align:middle;text-align:left;"> '+'-' + ' </div>');
						}
						else{
							return  String.format('<div style="vertical-align:middle;text-align:left;"> '+ "<font color='red'>"+record.data.peso_temp +"</font>"+'</div>');
						} 
	                }                
				},
				type:'TextField',
				filters:{pfiltro:'peso_temp',type:'numeric'},
				grid:true,
				form:true 
			};						
		}		
		//
        var contador=0;
		for (var i=0;i<arrayMeses.length;i++)
		{
			col_generado=col_generado+'@'+arrayMeses[i];	
			this.fields.push(arrayMeses[i]);
		   	this.Atributos.push({
		   		config:{
					name: arrayMeses[i],
					fieldLabel: arrayMeses[i],
					allowBlank: true,
					anchor: '80%',
					gwidth: 80,
					maxLength:100,
				},
				type:'NumberField',
				filters:{pfiltro:arrayMeses[i],type:'string'},
				id_grupo:1,
				egrid:true,
				grid:true,
				form:true
			});
							
			this.Atributos.push({
				config:{
					name: arrayMeses[i],
					inputType:'hidden'
				},
				type:'Field',
				form:true
			}); 
	
			if(arrayMeses[i]!='total')
			{					  		
				contador++;
				this.fields.push(contador.toString())
				this.Atributos.push({
					config:{
						labelSeparator:'',
						inputType:'hidden',
						name: contador.toString()
					},
					type:'Field',
					form:true 
				});
			}						
		}						
		//		        
		Phx.CP.loadingHide();
		Phx.vista.FormAvance.superclass.constructor.call(this, this.config);
		//this.argumentExtraSubmit={'id_correlativo': this.configMaestro.data.id_correlativo,'datos': col_generado};
		this.init();
		this.load({params: {'id_gestion': gestion}});		
		this.grid.addListener('cellclick', this.oncellclick,this);
        this.grid.addListener('afteredit', this.onAfterEdit, this);							           		
	},	
	//
	oncellclick : function(grid, rowIndex, columnIndex, e) {
	 	var record = this.store.getAt(rowIndex),
	 	fieldName = grid.getColumnModel().getDataIndex(columnIndex);
        if(fieldName=='total' || record.data['cod_prioridad_temp']=='0' || record.data['cod_prioridad_temp']=='-'){
        	alert('campo no editable');	
		}	
	},
	//
	handleClick:function (e, t){ 
	    e.preventDefault();
	    var target = e.getTarget(); 
	},
	//
	onAfterEdit:function(prueba){	
		var columna = prueba.field;
        var peso = prueba.record.data['peso_temp'];
        var cod_prioridad = prueba.record.data['cod_prioridad_temp'];        
        this.store.each(function(r){
            var sumTotal=0.00;
			for (var i=0;i<arrayMeses.length-1;i++){																	
				if(r.data[arrayMeses[i]]=='' ){
					if(r.data.cod_prioridad_temp!='-'){
						r.data[arrayMeses[i]]=0;
					}				
				}
				if(peso!='-'){					
					sumTotal +=parseFloat(r.data[arrayMeses[i]]);
					sum=sumTotal;	
				}
				if(sum>100){					
					sumTotal=sum-r.data[arrayMeses[i]];					
					alert("Error, corrija el dato ingresado, la sumatoria no puede ser mayor a 100");																			
					r.data[arrayMeses[i]]=0;
					console.log('->'+prueba.record);
					break;
				}								
			}						
			if(peso!='-' && r.data.cod_prioridad_temp!='-'){					
				r.set('total',sumTotal);				
			}	
		},this);    
    },
	//
	tam_pag:500,	
	title:'Curso - Avance Real',
	ActSave:'../../sis_formacion/control/Curso/insertarAvanceReal',
	ActDel: '../../sis_formacion/control/LineaAvance/eliminarLineaAvance',
	ActList:'../../sis_formacion/control/Curso/listarCursoAvanceDinamico',
	bdel:false,
	bsave:true, 
	bedit:false, 
	bnew:false
})
</script>
		
		