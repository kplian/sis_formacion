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
var arrayMeses = [];
var sw = true;
var v_id_gestion;
var vgestion;
var v_id_correlativo = null;
var v_id_curso = null;
var v_padre='%';
Phx.vista.FormCursoAvanceReal = Ext.extend(Phx.arbGridInterfaz, {
		
    constructor: function (config) {
		this.maestro=config.maestro;
		this.initButtons = [this.cmbGestion];
    	//llama al constructor de la clase padre
		Phx.vista.FormCursoAvanceReal.superclass.constructor.call(this,config);							
		this.loaderTree.baseParams = {id_gestion: undefined};
		this.init();
		this.cmbGestion.on('select', this.capturaFiltros, this);
		
		this.addButton('btnAvances', {
            text: 'Avances',
            iconCls: 'block',
            disabled: false,
            handler: this.AsignarAvance,
            tooltip: '<b>Avances</b>'
        });		
        this.treePanel.expandAll();				
    },
    //
    AsignarAvance: function (record) {
        this.GenerarColumnas('new', this);      
    },
    //
    openAvance: function () {  	  	       
		if (this.cmbGestion.getValue()) {        	        	
        	var me = this; 
	        Phx.CP.loadingShow();
	    	me.objSolForm = Phx.CP.loadWindows('../../../sis_formacion/vista/curso/FormAvance.php',
	        'Formulario de Avance',
	        {
	            modal: true,
	            width: '80%',
	            height: '60%'
	        }, 
	        {
	            data: 
	            {
	                'id_gestion': v_id_gestion,
	                meses: arrayMeses
	            }
	        },
	        this.idContenedor,
	        'FormAvance',
	        );	
        } else {
        	alert('Seleccione una gestion');	
        }
    },
    //
    onSaveForm: function (interface,valores,id) {
		alert('Guardado Correctamente');
		interface.panel.close();
    },	
    //
	GenerarColumnas: function (){
    	Ext.Ajax.request({
			url: '../../sis_formacion/control/Curso/GenerarColumnaMeses',
			params: {
			    'id_gestion': v_id_gestion,
			},
			success: this.RespuestaColumnas,
			failure: this.conexionFailure,
			timeout: this.timeout,
			scope: this
		}); 
	},
	//
	RespuestaColumnas: function (s,m){		
        this.maestro = m;
        var meses = s.responseText.split('%');
		arrayMeses = meses[1].split(",");
		this.openAvance();
	},
    //
    successSaveAprobar: function () {
        Phx.CP.loadingHide();
        this.root.reload();
        Ext.MessageBox.alert('id_correlativo');
    },
    //
    conexionFailureAprobar: function () {
        Phx.CP.loadingHide(); 	
        alert('Error');
        this.root.reload();
    }, 
    //
    onButtonAct: function () {
        this.root.reload();
    	this.treePanel.expandAll();	
    },
    //
    capturaFiltros: function (combo, record, index) {
    	this.desplegarArbol();	
    },  
    //
    desplegarArbol:function(){
    	v_id_gestion=this.cmbGestion.getValue()
		this.loaderTree.baseParams = {id_gestion: this.cmbGestion.getValue()};		
        this.root.reload();
        this.treePanel.expandAll();	
	},
	//
	loadValoresIniciales: function () {
        Phx.vista.FormCursoAvanceReal.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_gestion').setValue(this.cmbGestion.getValue());
    },   
    //
    onReloadPage: function (m) {     
	   this.maestro = m;
	   this.loaderTree.baseParams = {id_curso: this.maestro.id_correlativo};  
	   v_id_correlativo=this.maestro.id_correlativo;			   
    },
    //
    cmbGestion: new Ext.form.ComboBox({
        fieldLabel: 'Gestion',
        allowBlank: true,
        emptyText: 'Gestion...',
        store: new Ext.data.JsonStore(
        {
            url: '../../sis_parametros/control/Gestion/listarGestion',
            id: 'id_gestion',
            root: 'datos',
            sortInfo: {
                field: 'gestion',
                direction: 'DESC'
            },
            
            totalProperty: 'total',
            fields: ['id_gestion', 'gestion'],
            remoteSort: true,
            baseParams: {par_filtro: 'gestion'}
        }),
        valueField: 'id_gestion',
        triggerAction: 'all',
        displayField: 'gestion',
        hiddenName: 'id_gestion',
        mode: 'remote',
        pageSize: 50,
        queryDelay: 500,
        listWidth: '280',
        width: 80
    }),    
    //           
    Atributos: [
    	{
            config: {
                name: 'id_correlativo',
                fieldLabel: 'id_correlativo',
                allowBlank: true,
                anchor: '80%',
                inputType:'hidden',
                gwidth: 150,
                maxLength: 150,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: false
        },
   		{
            config: {
                name: 'id_correlativo_key',
                fieldLabel: 'id_correlativo_key',
                allowBlank: true,
                anchor: '80%',
                inputType:'hidden',
                gwidth: 150,
                maxLength: 150,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: false
        },
   		{
            config: {
                name: 'id_uo_temp',
                fieldLabel: 'id_uo_temp',
                allowBlank: true,
                anchor: '80%',
                inputType:'hidden',
                gwidth: 150,
                maxLength: 150,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid:false
        },
        {
            config: {
                name: 'id_uo_t_temp',
                fieldLabel: 'id_uo_t_temp',
                allowBlank: true,
                anchor: '80%',
                inputType:'hidden',
                gwidth: 150,
                maxLength: 150,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: false 	 	
        },
        {
            config: {
                fieldLabel: 'id_uo_padre_temp',
                name: 'id_uo_padre_temp',
                inputType:'hidden',
                allowBlank: true,
                inputType:'hidden',
                anchor: '80%',
                gwidth: 150,
                maxLength: 150,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: false
        },
        {
            config: {
                fieldLabel: 'id_curso_temp',
                name: 'id_curso_temp',
                allowBlank: true,
                inputType:'hidden',
                anchor: '80%',
                gwidth: 150,
                maxLength: 150,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid:false
        },             
        {
            config: {
                name: 'nombre_unidad_temp',
                fieldLabel: 'Unidad Organizacional:',
                allowBlank: true,
                anchor: '80%',
                gwidth: 250,
                maxLength: 150,
                disabled: true
            },
            filters: {pfiltro: 'padre.nombre_unidad_temp', type: 'string'},
            type: 'Field',
            form: true,
            grid:true
        },
        {
            config: {
                fieldLabel: 'Curso',
                name: 'nombre_curso_temp',
                allowBlank: true,
                inputType:'hidden',
                anchor: '80%',
                gwidth: 250,
                maxLength: 150,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: false
        },
        {
            config: {
                name: 'cod_prioridad_temp',
                fieldLabel: 'Prioridad',
                allowBlank: true,
                anchor: '80%',
                gwidth: 150,
                maxLength: 150,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: true
        },
        {
            config: {
                name: 'tipo_nodo_temp',
                fieldLabel: 'tipo_nodo_temp',
                allowBlank: true,
                inputType:'hidden',
                anchor: '80%',
                gwidth: 150,
                maxLength: 150,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: false
        },
        {
            config: {
                name: 'horas_temp',
                fieldLabel: 'Horas',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:100,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: true
        },
        {
            config: {
                name: 'cantidad_temp',
                fieldLabel: 'Cantidad de personas',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength: 100,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: true
        },
        {
            config: {
                name: 'prioridad_temp',
                fieldLabel: 'Prioridad',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength: 100,
                disabled: true
            },
            type: 'Field',
            form: true,
            grid: false
        },
        {
            config: {
                name: 'tparcial_temp',
                fieldLabel: 'Total',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength: 100
            },
            type: 'Field',
            form: true,
            grid: false
        },
        {
            config: {
                name: 'peso_temp',
                fieldLabel: 'Peso',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength: 100,
                disabled: true,
                decimalPrecision : 3,
				forceDecimals : true
            },
            type: 'Field',
            form: true,
            grid: true
        }        
    ],
    
    NodoCheck: false,//si los nodos tienen los valores para el check
    id_nodo: 'id_correlativo_key',
    id_nodo_p: 'id_uo_padre_temp',
    enableDD: false,
    rootVisible: false,
    baseParams: {clasificacion: true},
    fwidth: 420,
    fheight: 250,
    title: 'Avance Real Curso',
    ActList: '../../sis_formacion/control/Curso/listarCursoAvanceArb',
    id_store: 'id_correlativo_key',
    
    fields: [
    	{name: 'id_correlativo', type: 'numeric'},
        {name: 'id_correlativo_key', type: 'numeric'},
    	{name: 'id_uo_t_temp', type: 'numeric'},
    	{name: 'id_uo_temp', type: 'numeric'},
    	{name: 'id_uo_padre_temp', type: 'numeric'},
        {name: 'nombre_unidad_temp', type: 'varchar'},
        {name: 'id_curso_temp', type: 'numeric'},
        {name: 'nombre_curso_temp', type: 'varchar'},
        {name: 'cod_prioridad_temp', type: 'varchar'},
        {name: 'tipo_nodo_temp', type: 'varchar'},
        {name: 'horas_temp', type: 'varchar'},
        {name: 'cantidad_temp', type: 'varchar'},
        {name: 'prioridad_temp', type: 'varchar'},
        {name: 'tparcial_temp', type: 'varchar'},
        {name: 'peso_temp', type: 'numeric'}
    ],
    
    bdel: false,
    bsave: false,
    bnew:false,
    bedit:false
})
</script>
		
		