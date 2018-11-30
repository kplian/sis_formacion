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
				allowBlank: false,
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
                       allowBlank: false,
                       emptyText: 'Elija una opción...',
                       store: new Ext.data.ArrayStore({
	                        id: 0,
	                        fields: [
	                            'tipo'
	                        ],
	                        data: [['Funcionario'], ['Proveedor']]
                       }),
                       valueField: 'tipo',
                       displayField: 'tipo',
                       gdisplayField: 'tipo',
                       hiddenName: 'tipo',
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

                },
                type: 'ComboBox',
                id_grupo: 0,
                filters: {pfiltro: 'sigefoco.tipo',type: 'string'},
                grid: true,
                form: true
                //,egrid:true,
        },
		{
			config:{
				name: 'habilitado',
				fieldLabel: 'Habilitar',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
                renderer: function (value, p, record, rowIndex, colIndex){
                    if(record.data.habilitado =='t'){
                        return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:37px;width:37px;" type="checkbox"  {0} {1}></div>','checked', 'disabled');
                    }
                    else{
                        return  String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:37px;width:37px;" type="checkbox"  {0} {1}></div>','', 'disabled');
                    }
                }
			},
				type:'Checkbox',
				filters:{pfiltro:'pre.habilitado',type:'boolean'},
				id_grupo:1,
				grid:true,
				form:true
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
		{name:'habilitado', type: 'string'}	
	],
	sortInfo:{
		field: 'id_categoria',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    onButtonEdit: function () {
        Phx.vista.Categoria.superclass.onButtonEdit.call(this);
        //console.log("ver editar ",this.Cmp.habilitado);
        //console.log("ver editar2 ",this.sm.selections.items[0].data.habilitado);
        if(this.sm.selections.items[0].data.habilitado=='t'){
        	this.Cmp.habilitado.setValue(true);
        }
    },
    onButtonNew: function() {
       	Phx.vista.Categoria.superclass.onButtonNew.call(this);
        this.Cmp.habilitado.setValue(true);
    },
    
    
	}
)
</script>
		
		