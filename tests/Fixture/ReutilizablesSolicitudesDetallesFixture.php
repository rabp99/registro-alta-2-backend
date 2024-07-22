<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ReutilizablesSolicitudesDetallesFixture
 */
class ReutilizablesSolicitudesDetallesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'solicitud_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'reutilizable_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'fecha' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'estado_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_reutilizables_solicitudes_detalles_solicitudes1_idx' => ['type' => 'index', 'columns' => ['solicitud_id'], 'length' => []],
            'fk_reutilizables_solicitudes_detalles_reutilizables1_idx' => ['type' => 'index', 'columns' => ['reutilizable_id'], 'length' => []],
            'fk_reutilizables_solicitudes_detalles_estados1_idx' => ['type' => 'index', 'columns' => ['estado_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'solicitud_id', 'reutilizable_id', 'estado_id'], 'length' => []],
            'fk_reutilizables_solicitudes_detalles_solicitudes1' => ['type' => 'foreign', 'columns' => ['solicitud_id'], 'references' => ['solicitudes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_reutilizables_solicitudes_detalles_reutilizables1' => ['type' => 'foreign', 'columns' => ['reutilizable_id'], 'references' => ['reutilizables', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_reutilizables_solicitudes_detalles_estados1' => ['type' => 'foreign', 'columns' => ['estado_id'], 'references' => ['estados', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'solicitud_id' => 1,
                'reutilizable_id' => 1,
                'fecha' => '2021-04-27',
                'estado_id' => 1,
            ],
        ];
        parent::init();
    }
}
