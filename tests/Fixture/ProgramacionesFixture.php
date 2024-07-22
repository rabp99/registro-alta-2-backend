<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProgramacionesFixture
 */
class ProgramacionesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'centro' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'periodo' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'area' => ['type' => 'string', 'length' => 90, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'servicio' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'actividad' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'subactividad' => ['type' => 'string', 'length' => 120, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'consultorio' => ['type' => 'string', 'length' => 90, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'ubicacionconsult' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'dni_medico' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'profesional' => ['type' => 'string', 'length' => 160, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'grupo_ocupacional' => ['type' => 'string', 'length' => 90, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'tip_programacion' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'fecha_programacion' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'hor_inicio' => ['type' => 'string', 'length' => 5, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'hor_fin' => ['type' => 'string', 'length' => 5, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'estado_programacion' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'motivo_suspension' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'cod_planilla' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'turno' => ['type' => 'string', 'length' => 15, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'condtrabajador' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'pertenece_otro_cas' => ['type' => 'string', 'length' => 2, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'area_ingreso' => ['type' => 'string', 'length' => 60, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'tipo_epp' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'cantidad' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['centro', 'dni_medico', 'fecha_programacion', 'turno'], 'length' => []],
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
                'centro' => 'da262c98-d6c0-4767-a196-53f7f211858d',
                'periodo' => 'Lorem ip',
                'area' => 'Lorem ipsum dolor sit amet',
                'servicio' => 'Lorem ipsum dolor sit amet',
                'actividad' => 'Lorem ipsum dolor sit amet',
                'subactividad' => 'Lorem ipsum dolor sit amet',
                'consultorio' => 'Lorem ipsum dolor sit amet',
                'ubicacionconsult' => 'Lorem ipsum dolor sit amet',
                'dni_medico' => '8d6c0367-36bb-46c9-b10d-8d526d8ed52c',
                'profesional' => 'Lorem ipsum dolor sit amet',
                'grupo_ocupacional' => 'Lorem ipsum dolor sit amet',
                'tip_programacion' => 'Lorem ip',
                'fecha_programacion' => '2021-04-20',
                'hor_inicio' => 'Lor',
                'hor_fin' => 'Lor',
                'estado_programacion' => 'Lorem ipsum d',
                'motivo_suspension' => 'Lorem ipsum dolor sit amet',
                'cod_planilla' => 'Lorem ip',
                'turno' => '7d8343f6-11ae-4359-8bd4-bcaee4608adb',
                'condtrabajador' => 'Lorem ipsum dolor sit amet',
                'pertenece_otro_cas' => 'Lo',
                'area_ingreso' => 'Lorem ipsum dolor sit amet',
                'tipo_epp' => 'Lorem ip',
                'cantidad' => 1,
            ],
        ];
        parent::init();
    }
}
