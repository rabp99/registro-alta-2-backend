<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CuestionariosFixture
 */
class CuestionariosFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'programacion_centro' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'programacion_dni_medico' => ['type' => 'string', 'length' => 9, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'programacion_fecha_programacion' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'programacion_turno' => ['type' => 'string', 'length' => 15, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'fecha_hora' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'supervisor_dni' => ['type' => 'string', 'length' => 9, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'supervisor_nombres' => ['type' => 'string', 'length' => 150, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_cuestionarios_programaciones1_idx' => ['type' => 'index', 'columns' => ['programacion_centro', 'programacion_dni_medico', 'programacion_fecha_programacion', 'programacion_turno'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'programacion_centro', 'programacion_dni_medico', 'programacion_fecha_programacion', 'programacion_turno'], 'length' => []],
            'fk_cuestionarios_programaciones1' => ['type' => 'foreign', 'columns' => ['programacion_centro', 'programacion_dni_medico', 'programacion_fecha_programacion', 'programacion_turno'], 'references' => ['programaciones', '1' => ['centro', 'dni_medico', 'fecha_programacion', 'turno']], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'programacion_centro' => '7b1c5e2a-ea65-4847-8da5-98b1d0e6f38c',
                'programacion_dni_medico' => 'c11c64ec-04a0-44d5-b288-7ad60ede9536',
                'programacion_fecha_programacion' => '2021-04-29',
                'programacion_turno' => '9da4e573-1b05-423e-9dc9-93786c38c2e1',
                'fecha_hora' => '2021-04-29 15:20:41',
                'supervisor_dni' => 'Lorem i',
                'supervisor_nombres' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
