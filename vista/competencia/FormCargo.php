<?php
/**
 * @package pXP
 * @file gen-Cargo.php
 * @author  (admin)
 * @date 14-01-2014 19:16:06
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormCargo = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config;
                this.initButtons = [this.cmbCompetencia];
                //llama al constructor de la clase padre
                Phx.vista.FormCargo.superclass.constructor.call(this, config);
                this.init();
                //this.iniciarEventos();
                this.load({params: {start: 0, limit: this.tam_pag}})
                this.cmbCompetencia.on('select', this.capturaFiltros, this);
                this.addButton('btnCompetencia',
                    {
                        text: 'Asignar_competencia',
                        iconCls: 'blist',
                        disabled: true,
                        handler: this.onBtnCompetencia,
                        tooltip: 'Asociar cargos con competencias'
                    }
                );
               /*this.store.baseParams.id_uo = this.maestro.id_uo;
                if (this.maestro.fecha) {
                    this.store.baseParams.fecha = this.maestro.fecha;
                }
                if (this.maestro.tipo) {
                    this.store.baseParams.tipo = this.maestro.tipo;
                }*/
                
                
            },
			//
            capturaFiltros: function (combo, record, index) {
                console.log('entre a los datos', this.cmbCompetencia.getValue())
                //carga los parametros del grid
                console.log("Probar contenido de combo ",combo);
                this.store.baseParams = {id_competencia: this.cmbCompetencia.getValue()};
                //this.load({params: {start: 0, limit: 50}})
                this.store.reload();
            },
			//
            Atributos: [
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_cargo'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_competencia'
                    },
                    type: 'Field',
                    form: false,
                    grid:false
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'cod_cargo'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'nombre_cargo',
                        fieldLabel: 'Nombre Cargo',
                        allowBlank: false,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_organigrama/control/TemporalCargo/listarTemporalCargo',
                            id: 'id_temporal_cargo',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre_cargo',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_temporal_cargo', 'nombre'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'cargo.nombre'}
                        }),
                        valueField: 'nombre_cargo',
                        displayField: 'nombre_cargo',
                        gdisplayField: 'nombre_cargo',
                        hiddenName: 'nombre_cargo',
                        forceSelection: false,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '100%',
                        gwidth: 200,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['nombre_cargo']);
                        }
                    },
                    type: 'ComboBox',
                    bottom_filter: true,
                    id_grupo: 0,
                    filters: {
                        pfiltro: 'c.nombre',
                        type: 'string'
                    },
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'funcionario',
                        fieldLabel: 'Funcionario',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10,

                
                    },
                    type: 'TextField',
                    bottom_filter: true,
                    filters: {
                        pfiltro: 'p.ap_paterno',
                        type: 'string'
                    },
                    filters: {pfiltro: 'p.nombre#p.ap_paterno#p.ap_materno', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },

            ],
            tam_pag: 50,
            title: 'Cargo',
            ActSave: '../../sis_organigrama/control/Cargo/insertarCargo',
            //ActDel:'../../sis_formacion/control/Competencia/eliminarCargoCompetencia',
            ActList: '../../sis_formacion/control/Competencia/listarCargo',
            id_store: 'id_cargo',
            fields: [
                {name: 'id_cargo', type: 'numeric'},
                {name: 'nombre_cargo', type: 'string'},
                {name: 'funcionario', type: 'string'},
                {name: 'cod_cargo', type: 'numeric'},
                {name: 'id_competencia', type: 'numeric'},

            ],
            sortInfo: {
                field: 'nombre_cargo',
                direction: 'ASC'
            },

            tabeast: [
                {                    
                    url: '../../../sis_formacion/vista/competencia/FormCargoCompetencia.php',
                    title: 'Competencias',
                    width: 500,
                    cls: 'FormCargoCompetencia'
                }
            ],
            bdel: false,
            bedit: false,
            bsave: false,
            bnew: false,
           /* iniciarEventos: function () {
                this.Cmp.id_tipo_contrato.on('select', function (x, rec, z) {

                    if (rec.data.codigo == 'PLA') {
                        this.ocultarComponente(this.Cmp.fecha_fin);
                        this.Cmp.fecha_fin.allowBlank = true;
                    } else {
                        this.mostrarComponente(this.Cmp.fecha_fin);
                        this.Cmp.fecha_fin.allowBlank = false;
                    }

                }, this);
            },*/
            loadValoresIniciales: function () {
                this.Cmp.id_uo.setValue(this.maestro.id_uo);
                Phx.vista.FormCargorgo.superclass.loadValoresIniciales.call(this);
            },
            preparaMenu: function () {
                this.getBoton('btnCompetencia').enable();
                Phx.vista.FormCargo.superclass.preparaMenu.call(this);
            },
            liberaMenu: function () {
                this.getBoton('btnCompetencia').disable();
                Phx.vista.FormCargo.superclass.liberaMenu.call(this);
            },

            onButtonEdit: function () {
                //this.ocultarComponente(this.Cmp.id_escala_salarial);
                this.ocultarComponente(this.Cmp.id_tipo_contrato);

                Phx.vista.FormCargo.superclass.onButtonEdit.call(this);
            },
            onButtonNew: function () {
                this.mostrarComponente(this.Cmp.id_escala_salarial);
                this.mostrarComponente(this.Cmp.id_tipo_contrato);
                Phx.vista.FormCargo.superclass.onButtonNew.call(this);
            },

            onBtnCompetencia: function () {

                var filas = this.sm.getSelections();
                var data = [], aux = {};
                //arma una matriz de los identificadores de registros que se van a eliminar
                this.agregarArgsExtraSubmit();
                var rr = {};
                for (var i = 0; i < this.sm.getCount(); i++) {
                    aux = {};
                    aux[this.id_store] = filas[i].data[this.id_store];
                    aux.cod_cargo = filas[i].data.cod_cargo;
                    data.push(aux);
                }
     			var rec = {maestro: this.sm.getSelected().data, cod_cargos: Ext.util.JSON.encode(data)}
                Phx.CP.loadWindows('../../../sis_formacion/vista/competencia/FormCompetencia.php',
                    'Cargos competencias',
                    {
                        width: 700,
                        height: 450
                    },
                    rec,this.idContenedor,'FormCompetencia');
            },
            cmbCompetencia: new Ext.form.ComboBox({
                    fieldLabel: 'Competencias',
                    allowBlank: true,
                    emptyText: 'Competencias...',
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
                    anchor: '60%',
                    gwidth: 150,
                    minChars: 2,
                    multiSelect: true,
                    enableMultiSelect: true,
                    renderer: function (value, p, record) {
                        return String.format('{0}', (record.data['desc_competencia']) ? record.data['desc_competencia'] : '');
                    }
                }
            )

        }
    )
</script>
		
		
 