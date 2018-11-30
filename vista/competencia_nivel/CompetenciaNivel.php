<?php
/**
*@package pXP
*@file gen-CompetenciaNivel.php
*@author  (jjimenez)
*@date 11-06-2018 20:42:44
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
var v_id_competencia=null;
Phx.vista.CompetenciaNivel=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.CompetenciaNivel.superclass.constructor.call(this,config);
		this.init();
        //this.store.baseParams = {id_competencia: 0};
        //this.load({params: {start: 0, limit: 50}})
	},
    onReloadPage: function (m) {
        this.maestro = m;
        var aa = this;
        //alert(this.maestro.id_competencia);
        Phx.vista.CompetenciaNivel.superclass.loadValoresIniciales.call(this);
        //this.Cmp.id_competencia.setValue(this.maestro.id_competencia);
        v_id_competencia=this.maestro.id_competencia;
        this.store.baseParams = {id_competencia: this.maestro.id_competencia};
        this.load({params: {start: 0, limit: 50}})
        
    },	
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_competencia_nivel'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_competencia'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'nivel',
				fieldLabel: 'Nivel',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'comniv.nivel',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'Descripcion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:2000
			},
				type:'TextField',
				filters:{pfiltro:'comniv.descripcion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
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
				filters:{pfiltro:'comniv.estado_reg',type:'string'},
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
				filters:{pfiltro:'comniv.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'comniv.fecha_reg',type:'date'},
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
				filters:{pfiltro:'comniv.usuario_ai',type:'string'},
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
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'comniv.fecha_mod',type:'date'},
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
	title:'Competencia nivel',
	ActSave:'../../sis_formacion/control/CompetenciaNivel/insertarCompetenciaNivel',
	ActDel:'../../sis_formacion/control/CompetenciaNivel/eliminarCompetenciaNivel',
	ActList:'../../sis_formacion/control/CompetenciaNivel/listarCompetenciaNivel',
	id_store:'id_competencia_nivel',
	fields: [
		{name:'id_competencia_nivel', type: 'numeric'},
		{name:'nivel', type: 'string'},
		{name:'id_competencia', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'descripcion', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_competencia_nivel',
		direction: 'ASC'
	},
    onButtonNew: function() {
       	Phx.vista.CompetenciaNivel.superclass.onButtonNew.call(this);
       	this.Cmp.id_competencia.setValue(v_id_competencia);
        //alert(v_id_competencia);
    },
	bdel:true,
	bsave:true
	}
)
</script>
		
		