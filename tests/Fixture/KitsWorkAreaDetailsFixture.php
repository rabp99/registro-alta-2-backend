<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitsWorkAreaDetailsFixture
 */
class KitsWorkAreaDetailsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'kit_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'work_area_detail_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'kit_id' => ['type' => 'index', 'columns' => ['kit_id', 'work_area_detail_id'], 'length' => []],
            'work_area_detail_id' => ['type' => 'index', 'columns' => ['work_area_detail_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'kits_work_area_details_ibfk_1' => ['type' => 'foreign', 'columns' => ['kit_id'], 'references' => ['kits', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'kits_work_area_details_ibfk_2' => ['type' => 'foreign', 'columns' => ['work_area_detail_id'], 'references' => ['work_area_details', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_0900_ai_ci'
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
                'kit_id' => 1,
                'work_area_detail_id' => 1,
                'amount' => 1,
                'created' => '2024-08-24 21:41:34',
                'modified' => '2024-08-24 21:41:34',
            ],
        ];
        parent::init();
    }
}
