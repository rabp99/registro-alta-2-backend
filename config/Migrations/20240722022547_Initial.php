<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up()
    {
        $this->table('colaboradores', ['id' => false, 'primary_key' => ['dni_medico']])
            ->addColumn('dni_medico', 'string', [
                'default' => null,
                'limit' => 9,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('nombre_completo', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('cod_planilla', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('grupo_ocupacional_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'estado_id',
                    'grupo_ocupacional_id',
                ]
            )
            ->create();

        $this->table('consumibles', ['id' => false, 'primary_key' => ['id', 'estado_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('descripcion', 'string', [
                'default' => null,
                'limit' => 90,
                'null' => false,
            ])
            ->addColumn('stock', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('marca', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->create();

        $this->table('cuadro_resumen', ['id' => false])
            ->addColumn('user_entrega_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('fecha_entrega_date_solicitud', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('nombre_completo', 'string', [
                'default' => null,
                'limit' => 120,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 90,
                'null' => false,
            ])
            ->addColumn('epp_0', 'decimal', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('epp_2', 'decimal', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('epp_5', 'decimal', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('epp_8', 'decimal', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('respiradores', 'decimal', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('n95', 'decimal', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('lentes', 'decimal', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('filtros', 'decimal', [
                'default' => null,
                'limit' => 32,
                'null' => true,
            ])
            ->addColumn('mandilones_tela', 'decimal', [
                'default' => null,
                'limit' => 23,
                'null' => true,
            ])
            ->addColumn('pantalones_tela', 'decimal', [
                'default' => null,
                'limit' => 23,
                'null' => true,
            ])
            ->addColumn('chaquetas_tela', 'decimal', [
                'default' => null,
                'limit' => 23,
                'null' => true,
            ])
            ->create();

        $this->table('cuestionarios', ['id' => false, 'primary_key' => ['id', 'programacion_centro', 'programacion_dni_medico', 'programacion_fecha_programacion', 'programacion_turno']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('programacion_centro', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('programacion_dni_medico', 'string', [
                'default' => null,
                'limit' => 9,
                'null' => false,
            ])
            ->addColumn('programacion_fecha_programacion', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('programacion_turno', 'string', [
                'default' => null,
                'limit' => 15,
                'null' => false,
            ])
            ->addColumn('fecha_hora', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('supervisor_dni', 'string', [
                'default' => null,
                'limit' => 9,
                'null' => false,
            ])
            ->addColumn('supervisor_nombres', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('observaciones', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'programacion_centro',
                    'programacion_dni_medico',
                    'programacion_fecha_programacion',
                    'programacion_turno',
                ]
            )
            ->create();

        $this->table('estados')
            ->addColumn('descripcion', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->create();

        $this->table('grupos', ['id' => false, 'primary_key' => ['id', 'estado_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('descripcion', 'string', [
                'default' => null,
                'limit' => 90,
                'null' => false,
            ])
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->create();

        $this->table('grupos_ocupacionales')
            ->addColumn('descripcion', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('flag_show', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->create();

        $this->table('preguntas', ['id' => false, 'primary_key' => ['id', 'grupo_id', 'estado_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('grupo_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('nro', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('descripcion', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('si_case', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addIndex(
                [
                    'grupo_id',
                ]
            )
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->create();

        $this->table('programaciones', ['id' => false, 'primary_key' => ['centro', 'dni_medico', 'fecha_programacion', 'turno']])
            ->addColumn('centro', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('dni_medico', 'string', [
                'default' => null,
                'limit' => 9,
                'null' => false,
            ])
            ->addColumn('fecha_programacion', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('turno', 'string', [
                'default' => null,
                'limit' => 15,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('periodo', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('area', 'string', [
                'default' => null,
                'limit' => 90,
                'null' => true,
            ])
            ->addColumn('servicio', 'string', [
                'default' => null,
                'limit' => 120,
                'null' => true,
            ])
            ->addColumn('actividad', 'string', [
                'default' => null,
                'limit' => 120,
                'null' => true,
            ])
            ->addColumn('subactividad', 'string', [
                'default' => null,
                'limit' => 120,
                'null' => true,
            ])
            ->addColumn('consultorio', 'string', [
                'default' => null,
                'limit' => 90,
                'null' => true,
            ])
            ->addColumn('ubicacionconsult', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('tip_programacion', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('hor_inicio', 'string', [
                'default' => null,
                'limit' => 5,
                'null' => true,
            ])
            ->addColumn('hor_fin', 'string', [
                'default' => null,
                'limit' => 5,
                'null' => true,
            ])
            ->addColumn('estado_programacion', 'string', [
                'default' => null,
                'limit' => 15,
                'null' => true,
            ])
            ->addColumn('condtrabajador', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('pertenece_otro_cas', 'string', [
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('fecha_hora_entrada', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('fecha_hora_salida', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('fecha_hora_break_start', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('fecha_hora_break_final', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('flag_interno', 'char', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('flag_entrada_sistema', 'char', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->create();

        $this->table('respuestas', ['id' => false, 'primary_key' => ['id', 'cuestionario_id', 'pregunta_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('cuestionario_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('pregunta_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('valor', 'char', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addIndex(
                [
                    'pregunta_id',
                ]
            )
            ->addIndex(
                [
                    'cuestionario_id',
                ]
            )
            ->create();

        $this->table('reutilizables', ['id' => false, 'primary_key' => ['id', 'tipo_id', 'estado_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tipo_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('codigo', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'tipo_id',
                ]
            )
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->create();

        $this->table('reutilizables_solicitudes_detalles', ['id' => false, 'primary_key' => ['id', 'solicitud_id', 'reutilizable_id', 'estado_id', 'user_registro_entrega_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('solicitud_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('reutilizable_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_registro_entrega_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('dni_medico', 'string', [
                'default' => null,
                'limit' => 9,
                'null' => false,
            ])
            ->addColumn('fecha_entrega', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('fecha_vestuario', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('fecha_lavanderia', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('fecha_devolucion', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_registro_vestuario_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_registro_lavanderia_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_registro_devolucion_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_registro_lavanderia_id',
                ]
            )
            ->addIndex(
                [
                    'user_registro_vestuario_id',
                ]
            )
            ->addIndex(
                [
                    'user_registro_devolucion_id',
                ]
            )
            ->addIndex(
                [
                    'user_registro_entrega_id',
                ]
            )
            ->addIndex(
                [
                    'solicitud_id',
                ]
            )
            ->addIndex(
                [
                    'reutilizable_id',
                ]
            )
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->create();

        $this->table('solicitudes', ['id' => false, 'primary_key' => ['id', 'estado_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('area_ingreso', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('tipo_epp', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addColumn('cantidad', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('fecha_solicitud', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('fecha_entrega', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('firma', 'text', [
                'default' => null,
                'limit' => 4294967295,
                'null' => true,
            ])
            ->addColumn('programacion_centro', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('programacion_dni_medico', 'string', [
                'default' => null,
                'limit' => 9,
                'null' => true,
            ])
            ->addColumn('programacion_fecha_programacion', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('programacion_turno', 'string', [
                'default' => null,
                'limit' => 15,
                'null' => true,
            ])
            ->addColumn('profesional', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('grupo_ocupacional', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('cod_planilla', 'string', [
                'default' => null,
                'limit' => 12,
                'null' => true,
            ])
            ->addColumn('user_entrega_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('flag_consumible', 'char', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_entrega_id',
                ]
            )
            ->addIndex(
                [
                    'programacion_centro',
                    'programacion_dni_medico',
                    'programacion_fecha_programacion',
                    'programacion_turno',
                ]
            )
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->create();

        $this->table('supervisores', ['id' => false, 'primary_key' => ['id', 'estado_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tipo_documento', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('nro_documento', 'string', [
                'default' => null,
                'limit' => 9,
                'null' => false,
            ])
            ->addColumn('trabajador', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->create();

        $this->table('tipos', ['id' => false, 'primary_key' => ['id', 'estado_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('descripcion', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('flag_salida', 'char', [
                'default' => null,
                'limit' => 1,
                'null' => true,
            ])
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->create();

        $this->table('users', ['id' => false, 'primary_key' => ['id', 'estado_id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('estado_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 90,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('nombre_completo', 'string', [
                'default' => null,
                'limit' => 120,
                'null' => false,
            ])
            ->addColumn('rol', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])->addColumn('created_by', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified_by', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'username',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'estado_id',
                ]
            )
            ->addIndex(
                [
                    'created_by',
                    'modified_by'
                ]
            )
            ->addForeignKey(
                'created_by',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'modified_by',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->create();

        $this->table('colaboradores')
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'grupo_ocupacional_id',
                'grupos_ocupacionales',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('consumibles')
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('cuestionarios')
            ->addForeignKey(
                [
                    'programacion_centro',
                    'programacion_dni_medico',
                    'programacion_fecha_programacion',
                    'programacion_turno',
                ],
                'programaciones',
                [
                    'centro',
                    'dni_medico',
                    'fecha_programacion',
                    'turno',
                ],
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('grupos')
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('preguntas')
            ->addForeignKey(
                'grupo_id',
                'grupos',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('programaciones')
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )->addForeignKey(
                'dni_medico',
                'colaboradores',
                'dni_medico',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('respuestas')
            ->addForeignKey(
                'pregunta_id',
                'preguntas',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'cuestionario_id',
                'cuestionarios',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('reutilizables')
            ->addForeignKey(
                'tipo_id',
                'tipos',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('reutilizables_solicitudes_detalles')
            ->addForeignKey(
                'user_registro_lavanderia_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'user_registro_vestuario_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'user_registro_devolucion_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'user_registro_entrega_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'solicitud_id',
                'solicitudes',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'reutilizable_id',
                'reutilizables',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('solicitudes')
            ->addForeignKey(
                'user_entrega_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                [
                    'programacion_centro',
                    'programacion_dni_medico',
                    'programacion_fecha_programacion',
                    'programacion_turno',
                ],
                'programaciones',
                [
                    'centro',
                    'dni_medico',
                    'fecha_programacion',
                    'turno',
                ],
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('supervisores')
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('tipos')
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('users')
            ->addForeignKey(
                'estado_id',
                'estados',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down()
    {
        $this->table('colaboradores')
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('consumibles')
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('cuestionarios')
            ->dropForeignKey(
                [
                    'programacion_centro',
                    'programacion_dni_medico',
                    'programacion_fecha_programacion',
                    'programacion_turno',
                ]
            )->save();

        $this->table('grupos')
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('preguntas')
            ->dropForeignKey(
                'grupo_id'
            )
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('programaciones')
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('respuestas')
            ->dropForeignKey(
                'pregunta_id'
            )
            ->dropForeignKey(
                'cuestionario_id'
            )->save();

        $this->table('reutilizables')
            ->dropForeignKey(
                'tipo_id'
            )
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('reutilizables_solicitudes_detalles')
            ->dropForeignKey(
                'user_registro_lavanderia_id'
            )
            ->dropForeignKey(
                'user_registro_vestuario_id'
            )
            ->dropForeignKey(
                'user_registro_devolucion_id'
            )
            ->dropForeignKey(
                'user_registro_entrega_id'
            )
            ->dropForeignKey(
                'solicitud_id'
            )
            ->dropForeignKey(
                'reutilizable_id'
            )
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('solicitudes')
            ->dropForeignKey(
                'user_entrega_id'
            )
            ->dropForeignKey(
                [
                    'programacion_centro',
                    'programacion_dni_medico',
                    'programacion_fecha_programacion',
                    'programacion_turno',
                ]
            )
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('supervisores')
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('tipos')
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('users')
            ->dropForeignKey(
                'estado_id'
            )->save();

        $this->table('colaboradores')->drop()->save();
        $this->table('consumibles')->drop()->save();
        $this->table('cuadro_resumen')->drop()->save();
        $this->table('cuestionarios')->drop()->save();
        $this->table('estados')->drop()->save();
        $this->table('grupos')->drop()->save();
        $this->table('grupos_ocupacionales')->drop()->save();
        $this->table('preguntas')->drop()->save();
        $this->table('programaciones')->drop()->save();
        $this->table('respuestas')->drop()->save();
        $this->table('reutilizables')->drop()->save();
        $this->table('reutilizables_solicitudes_detalles')->drop()->save();
        $this->table('solicitudes')->drop()->save();
        $this->table('supervisores')->drop()->save();
        $this->table('tipos')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
