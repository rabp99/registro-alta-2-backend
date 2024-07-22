<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HistorialConsumiblesFixture
 */
class HistorialConsumiblesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'consumible_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipo' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'fecha' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'cantidad' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'entrega_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_historial_consumibles_consumibles1_idx' => ['type' => 'index', 'columns' => ['consumible_id'], 'length' => []],
            'fk_historial_consumibles_entregas1_idx' => ['type' => 'index', 'columns' => ['entrega_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'consumible_id'], 'length' => []],
            'fk_historial_consumibles_entregas1' => ['type' => 'foreign', 'columns' => ['entrega_id'], 'references' => ['entregas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_historial_consumibles_consumibles1' => ['type' => 'foreign', 'columns' => ['consumible_id'], 'references' => ['consumibles', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'consumible_id' => 1,
                'tipo' => 'Lorem ip',
                'fecha' => '2021-05-21 11:37:39',
                'cantidad' => 1,
                'entrega_id' => 1,
            ],
        ];
        parent::init();
    }
}
