<?php
/**
 * @package pXP
 * @file gen-Competencia.php
 * @author  (admin)
 * @date 04-05-2017 19:30:13
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormCargoCompetencia = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                Phx.vista.FormCargoCompetencia.superclass.constructor.call(this, config);
                this.init();
            },
			//
            onReloadPage: function (m) {
                this.maestro = m;
                var aa = this;
                this.store.baseParams = {id_cargo: this.maestro.id_cargo};
                this.load({params: {start: 0, limit: 50}})
            },
            //
            onButtonDel: function () {
                if (confirm('¿Está seguro de Denegar competencia?')) {
                    var filas = this.sm.getSelections();
                    var data = [], aux = {};

                    this.agregarArgsExtraSubmit();
                    for (var i = 0; i < this.sm.getCount(); i++) {
                        aux = {};
                        aux[this.id_store] = filas[i].data[this.id_store];
                        aux.cod_competencia = filas[i].data.cod_competencia;
                        data.push(aux);
                    }

                    //llama el metodo en la capa de control para eliminación
                    var me = this;
                    Ext.Ajax.request({
                        url: '../../sis_formacion/control/Competencia/eliminarCargoCompetencia',
                        params: {
                            id_cargo: this.store.baseParams.id_cargo,
                            competencias: Ext.util.JSON.encode(data)
                        },
                        success: me.successSave,
                        failure: me.conexionFailure,
                        timeout: me.timeout,
                        scope: me
                    });

                }
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
                        name: 'cod_competencia'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'competencia',
                        fieldLabel: 'Competencia',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 200
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sigefoco.competencia', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'tipo',
                        fieldLabel: 'Tipo',
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
                },
                {
                    config: {
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sigefoco.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: '',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'sigefoco.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu1.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'sigefoco.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 300
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sigefoco.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu2.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'sigefoco.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            tam_pag: 50,
            title: 'Competencias',
            ActSave: '../../sis_formacion/control/Competencia/insertarCompetencia',
            ActDel: '../../sis_formacion/control/Competencia/eliminarCargoCompetencia',
            ActList: '../../sis_formacion/control/Competencia/listarCompetenciaCargo',
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
                {name: 'id_cargo', type: 'numeric'},
            ],
            sortInfo: {
                field: 'id_competencia',
                direction: 'ASC'
            },
            bdel: true,
            bedit: false,
            bsave: false,
            bnew: false
        }
    )
</script>
		
		