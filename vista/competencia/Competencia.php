<?php
/**
 * @package pXP
 * @file gen-Competencia.php
 * @author  (admin)
 * @date 04-05-2017 19:30:13
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema

 *
HISTORIAL DE MODIFICACIONES:

ISSUE            FECHA:		      AUTOR                 DESCRIPCION
#7               05/03/2020          JJA                   agregar gestión en competencias
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.Competencia = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                this.initButtons = [this.cmbGestion]; //#7
                //llama al constructor de la clase padre
                Phx.vista.Competencia.superclass.constructor.call(this, config);
                this.init();
                this.load({params: {start: 0, limit: this.tam_pag}})
                this.iniciarEventos(); //#7
            },
            cmbGestion: new Ext.form.ComboBox({ //#7
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
                        // turn on remote sorting
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
            iniciarEventos: function () {//#7

                this.cmbGestion.on('select',
                    function (cmb, dat) {
                        this.sm.clearSelections();
                        this.store.baseParams = {id_gestion: dat.data.id_gestion};
                        this.store.reload();
                    }, this);
            },
			//
            Atributos: [
                {                  
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_competencia'
                    },
                    type: 'Field',
                    form: true
                },
                {//#7
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_gestion'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'cod_competencia'
                    },
                    type: 'Field',
                    form: true
                },

                {
                    config: {
                        name: 'competencia',
                        fieldLabel: 'Competencias',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 200
                    },
                    type: 'TextField',
                    bottom_filter: true,
                    filters: {pfiltro: 'sigefoco.competencia', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'descripcion',
                        fieldLabel: 'Descripcion',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 2000
                    },
                    type: 'TextField',
                    bottom_filter: true,
                    filters: {pfiltro: 'sigefoco.descripcion', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'tipo',
                        fieldLabel: 'Tipos',
                        anchor: '90%',
                        tinit: false,
                        allowBlank: false,
                        origen: 'CATALOGO',
                        gdisplayField: 'tipo',
                        gwidth: 200,
                        anchor: '80%',
                        baseParams: {
                            cod_subsistema: 'SIGEFO',
                            catalogo_tipo: 'tipocompetencia'
                        },
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['tipo']);
                        },
                        valueField: 'codigo'
                    },
                    type: 'ComboRec',
                    bottom_filter: true,
                    id_grupo: 0,
                    filters: {
                        pfiltro: 'sigefoco.tipo',
                        type: 'string'
                    },
                    grid: true,
                    form: true
                }
            ],
            tam_pag: 50,
            title: 'Competencias',
            ActSave: '../../sis_formacion/control/Competencia/insertarCompetencia',
            ActDel: '../../sis_formacion/control/Competencia/eliminarCompetencia',
            ActList: '../../sis_formacion/control/Competencia/listarCompetencia',
            id_store: 'id_competencia',
            fields: [
                {name: 'id_competencia', type: 'numeric'},
                {name: 'tipo', type: 'string'},
                {name: 'estado_reg', type: 'string'},
                {name: 'competencia', type: 'string'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'cod_competencia', type: 'numeric'},
                {name: 'descripcion', type: 'string'},

                {name: 'id_gestion', type: 'numeric'}, //#7

            ],
            sortInfo: {
                field: 'id_competencia',
                direction: 'ASC'
            },
            tabeast: [
                {                    
                    url: '../../../sis_formacion/vista/competencia_nivel/CompetenciaNivel.php',
                    title: 'Nivel',
                    width: 500,
                    cls: 'CompetenciaNivel'
                }
            ],
            bdel: true,
            bsave: false,
            onButtonNew: function() { //#7
                //Phx.vista.Competencia.superclass.onButtonNew.call(this);
                autocompletado=false;//#5
                if(!this.cmbGestion.getValue()){
                    alert("Seleccione una gestion");
                }
                else{
                    this.window.buttons[0].show();
                    this.form.getForm().reset();
                    this.loadValoresIniciales();
                    this.window.show();
                    if(this.getValidComponente(0)){
                        this.getValidComponente(0).focus(false,100);
                    }
                }

            },
            onButtonEdit: function () {
                Phx.vista.Competencia.superclass.onButtonEdit.call(this);

                this.window.show();
                this.loadForm(this.sm.getSelected())

                this.window.buttons[0].hide();
                this.loadValoresIniciales();
            },
            loadValoresIniciales: function () {
                Phx.vista.Competencia.superclass.loadValoresIniciales.call(this);
                this.getComponente('id_gestion').setValue(this.cmbGestion.getValue());
                
            }
        }
    )
</script>
		
		