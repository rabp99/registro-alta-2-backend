<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EntradasFixture
 */
class EntradasFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'trabajador_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'area_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'fecha_hora' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'estado_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_entradas_trabajadores1_idx' => ['type' => 'index', 'columns' => ['trabajador_id'], 'length' => []],
            'fk_entradas_estados1_idx' => ['type' => 'index', 'columns' => ['estado_id'], 'length' => []],
            'fk_entradas_users1_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'fk_entradas_areas1_idx' => ['type' => 'index', 'columns' => ['area_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'trabajador_id', 'user_id', 'area_id', 'estado_id'], 'length' => []],
            'fk_entradas_users1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_entradas_trabajadores1' => ['type' => 'foreign', 'columns' => ['trabajador_id'], 'references' => ['trabajadores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_entradas_estados1' => ['type' => 'foreign', 'columns' => ['estado_id'], 'references' => ['estados', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_entradas_areas1' => ['type' => 'foreign', 'columns' => ['area_id'], 'references' => ['areas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'trabajador_id' => 1,
                'user_id' => 1,
                'area_id' => 1,
                'fecha_hora' => '2021-04-20 14:56:27',
                'estado_id' => 1,
            ],
        ];
        parent::init();
    }
}
