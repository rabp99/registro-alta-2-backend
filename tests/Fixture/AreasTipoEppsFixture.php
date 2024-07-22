<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AreasTipoEppsFixture
 */
class AreasTipoEppsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'area_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tipos_epp_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_tipos_epps_has_areas_areas1_idx' => ['type' => 'index', 'columns' => ['area_id'], 'length' => []],
            'fk_tipos_epps_has_areas_tipos_epps1_idx' => ['type' => 'index', 'columns' => ['tipos_epp_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['area_id', 'tipos_epp_id'], 'length' => []],
            'fk_tipos_epps_has_areas_tipos_epps1' => ['type' => 'foreign', 'columns' => ['tipos_epp_id'], 'references' => ['tipos_epps', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_tipos_epps_has_areas_areas1' => ['type' => 'foreign', 'columns' => ['area_id'], 'references' => ['areas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'area_id' => 1,
                'tipos_epp_id' => 1,
            ],
        ];
        parent::init();
    }
}
