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
    Phx.vista.Competencia = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.Competencia.superclass.constructor.call(this, config);
                this.init();
                this.load({params: {start: 0, limit: this.tam_pag}})
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
                    filters: {pfiltro: 'sigefoco.competencia', type: 'string'},
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

            ],
            sortInfo: {
                field: 'id_competencia',
                direction: 'ASC'
            },
            bdel: true,
            bsave: false
        }
    )
</script>
		
		