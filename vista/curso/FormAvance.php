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
		
	    arrayMeses=this.configMaestro.data.meses;
	    gestion=this.configMaestro.data.id_gestion;
		Phx.CP.loadingShow();	
		this.storeAtributos= new Ext.data.JsonStore({	
			url:'../../sis_formacion/control/Curso/listarCurso',	//llamamos a la misma lista de cursos 		
			id: 'id_curso',
			root: 'datos',			
			totalProperty: 'total',
			fields: 
			[
				'id_curso',
				{name:'nombre_curso', type: 'string'},				
				{name:'id_gestion', type: 'numeric'},
				{name:'cod_prioridad', type: 'varchar'},
				{name:'horas', type: 'numeric'},
				{name:'peso', type: 'numeric'},			
			],
			
			sortInfo:{
				field: 'id_curso',
				direction: 'ASC'
			}
		});
		this.storeAtributos.on('loadexception',this.conexionFailure);				
		this.storeAtributos.load({
			params:
			{
				"sort":"id_curso",
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
		this.id_store='id_curso';	
		this.sortInfo=
		{
			field: 'id_curso',
			direction: 'ASC'
		};		
		
		this.fields.push(this.id_store)
		this.fields.push('id_curso')
		this.fields.push({name:'nombre_curso', type: 'TextField'})
		this.fields.push({name:'cod_prioridad', type: 'TextField'})
		this.fields.push('peso')
				
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
					name: this.id_curso
				},
				type:'Field',
				form:true 
			};
			this.Atributos[2]=
			{
				config:{							
					name: 'nombre_curso',
					fieldLabel: 'Curso',
					allowBlank: false,
                    renderer: function (value, p, record, rowIndex, colIndex){

						       return  String.format('<div style="vertical-align:middle;text-align:left;">  <img src="../../../lib/imagenes/a_form.png"> '+ record.data.nombre_curso+' </div>');

					},
					anchor: '80%',
					gwidth: 230,
                	maxLength: 150,	                
				},
				type:'TextField',
				filters:{pfiltro:'nombre_curso',type:'string'},
				grid:true,
				form:true 
			};
			this.Atributos[3]=
			{
				config:{							
					name: 'cod_prioridad',
					fieldLabel: 'Prioridad',
					allowBlank: false,
                    renderer: function (value, p, record, rowIndex, colIndex){
		
                        return record.data.cod_prioridad;
					},
					anchor: '80%',
					gwidth: 70,
	                maxLength: 150,                
				},
				type:'TextField',
				filters:{pfiltro:'cod_prioridad',type:'string'},
				grid:true,
				form:true 
			};
			this.Atributos[4]=
			{
				config:{							
					name: 'peso',
					fieldLabel: 'Peso',
					allowBlank: false,
	                renderer: function (value, p, record, rowIndex, colIndex){
		
                        return record.data.peso;
					},
					anchor: '80%',
					gwidth: 50,
	                maxLength: 150,                
				},
				type:'TextField',
				filters:{pfiltro:'peso',type:'numeric'},
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
					gwidth: 70,
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

			if(arrayMeses[i]!='total'){
			  	  contador++;
			  	  
			      this.fields.push('id_lavance'+contador.toString())
			      
			      		this.Atributos.push({config:{
										labelSeparator:'',
										inputType:'hidden',
										maxLength:100,
										name: 'id_lavance'+contador.toString()
								},
								type:'Field',
								form:true 
						});
			  }
			  					
		}						
		//		        
		Phx.CP.loadingHide();
		Phx.vista.FormAvance.superclass.constructor.call(this, this.config);
		this.argumentExtraSubmit={'datos': col_generado};
		this.init();
		this.grid.addListener('cellclick', this.oncellclick,this);
        this.grid.addListener('afteredit', this.onAfterEdit, this);		
        
        this.store.baseParams={'id_gestion': this.configMaestro.data.id_gestion , 'datos': col_generado};			               
		this.load();				           		
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
        //var peso = prueba.record.data['peso'];
        //var cod_prioridad = prueba.record.data['cod_prioridad'];   
        var id_curso=prueba.record.data['id_curso'];

        this.store.each(function(r){
            var sumTotal=0.00;
            if(id_curso==r.data.id_curso){
            	
		        if((prueba.value).toString().trim()==''){
				    r.set(columna,0);
				}
				for (var i=0;i<arrayMeses.length-1;i++){																	
					sumTotal +=parseFloat(r.data[arrayMeses[i]]);				
				}	
				if(sumTotal>100){			
					r.set(columna,0);						
					alert("ERROR!! El monto ingresado ocaciona un desborde mayor a 100 en el total");																			
				}
				else{
					r.set('total',sumTotal);
					this.InsertarAvanceReal();
				}			
			}
			
		},this);    
    },
    InsertarAvanceReal: function (){
    	
	    	var filas=this.store.getModifiedRecords();
			if(filas.length>0){	
						//prepara una matriz para guardar los datos de la grilla
						var data={};
						for(var i=0;i<filas.length;i++){
							 //rac 29/10/11 buscar & para remplazar por su valor codificado
							 data[i]=filas[i].data;
							 //captura el numero de fila
							 data[i]._fila=this.store.indexOf(filas[i])+1
							 //RCM 12/12/2011: Llamada a función para agregar parámetros
							this.agregarArgsExtraSubmit(filas[i].data);
							Ext.apply(data[i],this.argumentExtraSubmit);
						    //FIN RCM
						}
						
			}
			
			Phx.CP.loadingShow();
	        Ext.Ajax.request({
	        	// form:this.form.getForm().getEl(),
	        	url:this.ActSave,
	        	params:{_tipo:'matriz','row':String(Ext.util.JSON.encode(data))},
			
				isUpload:this.fileUpload,
				success:this.successSaveFileUpload,
				//argument:this.argumentSave,
				failure: this.conexionFailure,
				timeout:this.timeout,
				scope:this
	        });

	   		this.store.rejectChanges();
		    Phx.CP.varLog=false;
	   		this.reload();
       
    },
	//
	tam_pag:500,	
	title:'Avance Real',
	ActSave:'../../sis_formacion/control/Curso/insertarAvanceReal',
	//ActDel: '../../sis_formacion/control/LineaAvance/eliminarLineaAvance',
	ActList:'../../sis_formacion/control/Curso/listarCursoAvanceDinamico',
	bdel:false,
	bsave:false, 
	bedit:false, 
	bnew:false
})
</script>
		
		