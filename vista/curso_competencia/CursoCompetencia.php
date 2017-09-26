<?php
/**
*@package pXP
*@file gen-CursoCompetencia.php
*@author  (admin)
*@date 22-01-2017 20:25:54
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.CursoCompetencia=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.CursoCompetencia.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
	}, 
        onReloadPage: function (m) {     
           this.maestro = m;
           var aa=this;
           this.store.baseParams = {id_curso: this.maestro.id_curso};
           this.load({params: {start: 0, limit: 50}})

          	console.log("ver id del curso ", this.maestro.id_curso);

         },
	   loadValoresIniciales: function () {
	    	//detalle
           Phx.vista.CursoCompetencia.superclass.loadValoresIniciales.call(this);
            //
           this.Cmp.id_curso.setValue(this.maestro.id_curso);

        },	
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_curso_competencia'
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
				name: 'id_competencia',
				fieldLabel: 'Competencia',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_formacion/control/Competencia/listarCompetencia',
					id: 'id_competencia',
					root: 'datos',
					sortInfo: {
						field: 'competencia',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_competencia', 'competencia'],
					remoteSort: true,
					baseParams: {par_filtro: 'competencia'}
				}),
				valueField: 'id_competencia',
				displayField: 'competencia',
				gdisplayField: 'competencia',
				hiddenName: 'id_competencia',
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
					return String.format('{0}', record.data['competencia']);
				}
			},
			//cambair el tipo de combo
			type: 'AwesomeCombo',
			id_grupo: 0,
			filters: {pfiltro: 'cuco.competencia',type: 'string'},
			grid: true,
			form: true
		},
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
				filters:{pfiltro:'cuco.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'cuco.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'cuco.usuario_ai',type:'string'},
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
				filters:{pfiltro:'cuco.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
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
				filters:{pfiltro:'cuco.fecha_mod',type:'date'},
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
		}
	],
	tam_pag:50,	
	title:'Curso competencia',
	ActSave:'../../sis_formacion/control/CursoCompetencia/insertarCursoCompetencia',
	ActDel:'../../sis_formacion/control/CursoCompetencia/eliminarCursoCompetencia',
	ActList:'../../sis_formacion/control/CursoCompetencia/listarCursoCompetencia',
	id_store:'id_curso_competencia',
	fields: [
		{name:'id_curso_competencia', type: 'numeric'},
		{name:'id_curso', type: 'numeric'},
		{name:'id_competencia', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'competencia', type: 'string'},

		
	],
	sortInfo:{
		field: 'id_curso_competencia',
		direction: 'ASC'
	},
	bdel:true,
	bsave:false,
	bedit:false
	}
)
</script>
		
		