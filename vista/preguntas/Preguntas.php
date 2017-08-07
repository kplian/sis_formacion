<?php
/**
*@package pXP
*@file gen-Preguntas.php
*@author  (admin)
*@date 20-04-2017 00:51:06
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Preguntas=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Preguntas.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}}) 
				    
        /*this.addButton('btnAvances', {
            text: 'Formulario',
            iconCls: 'block',
            disabled: false,
            handler: this.AsignarAvance,
            tooltip: '<b>Formulario</b>'
        });	*/	
	},
	//
    /*
    AsignarAvance: function (record) {
        this.Cuestionario('new', this);      
    },
    //    
	Cuestionario: function () {  	  	              	        	
		var me = this; 
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
            }
        },
        this.idContenedor,
        'FormProveedorEva',
        );	
    }, 
    */
	//		
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_pregunta'
			},
			type:'Field',
			form:true 
		},
		{
			config: {
				name: 'id_categoria',
				fieldLabel: 'Categoria',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_formacion/control/Categoria/listarCategoria',
					id: 'id_categoria',
					root: 'datos',
					sortInfo: {
						field: 'categoria',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_categoria', 'categoria'],
					remoteSort: true,
					baseParams: {par_filtro: 'categoria'}
				}),
				valueField: 'id_categoria',
				displayField: 'categoria',
				gdisplayField: 'categoria',
				hiddenName: 'id_categoria',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '80%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['categoria']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'categoria',type: 'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'pregunta',
				fieldLabel: 'Pregunta',
				allowBlank: false,
				anchor: '80%',
				gwidth: 400,
				maxLength:1500
			},
				type:'TextArea',
				filters:{pfiltro:'pre.pregunta',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
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
	                        data: [['Selección'], ['Multiple']]
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
        }
	],
	tam_pag:50,	
	title:'Preguntas',
	ActSave:'../../sis_formacion/control/Preguntas/insertarPreguntas',
	ActDel:'../../sis_formacion/control/Preguntas/eliminarPreguntas',
	ActList:'../../sis_formacion/control/Preguntas/listarPreguntas',
	id_store:'id_pregunta',
	fields: [
		{name:'id_pregunta', type: 'numeric'},
		{name:'id_categoria', type: 'numeric'},
		{name:'categoria', type: 'string'},
		{name:'tipo', type: 'string'},
		{name:'pregunta', type: 'string'},
		{name:'habilitado', type: 'string'}	
	],
	sortInfo:{
		field: 'id_pregunta',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    onButtonEdit: function () {
        Phx.vista.Preguntas.superclass.onButtonEdit.call(this);
        //console.log("ver editar ",this.Cmp.habilitado);
        //console.log("ver editar2 ",this.sm.selections.items[0].data.habilitado);
        if(this.sm.selections.items[0].data.habilitado=='t'){
        	this.Cmp.habilitado.setValue(true);
        }
    },
    onButtonNew: function() {
       	Phx.vista.Preguntas.superclass.onButtonNew.call(this);
        this.Cmp.habilitado.setValue(true);
    },
    
    
	}
)
</script>
		
		