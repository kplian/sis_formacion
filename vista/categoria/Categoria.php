<?php
/**
*@package pXP
*@file gen-Categoria.php
*@author  (admin)
*@date 20-04-2017 00:51:02
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Categoria=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Categoria.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_categoria'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'categoria',
				fieldLabel: 'Categoria',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'cat.categoria',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
            config: {
                name: 'tipo',
                fieldLabel: 'Tipo',
                tinit: false,
                allowBlank: false,
                emptyText: 'Elija una opción...',
                origen: 'CATALOGO',
                gdisplayField: 'tipo',
                gwidth: 100,
                anchor: '80%',
                baseParams: {
                    cod_subsistema: 'SIGEFO',
                    catalogo_tipo: 'tipo_categoria'
                },
                renderer: function (value, p, record) {
                    return String.format('{0}', record.data['tipo']);
                }
            },
            type: 'ComboRec',
            id_grupo: 0,
            filters: {
                pfiltro: 'sigefoco.tipo',
                type: 'string'
            },
            grid: true,
            form: true
        }
	],
	tam_pag:50,	
	title:'Categoria',
	ActSave:'../../sis_formacion/control/Categoria/insertarCategoria',
	ActDel:'../../sis_formacion/control/Categoria/eliminarCategoria',
	ActList:'../../sis_formacion/control/Categoria/listarCategoria',
	id_store:'id_categoria',
	fields: [
		{name:'id_categoria', type: 'numeric'},
		{name:'categoria', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'tipo', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_categoria',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		