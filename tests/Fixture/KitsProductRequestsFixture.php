<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitsProductRequestsFixture
 */
class KitsProductRequestsFixture extends TestFixture
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
        'product_request_year' => ['type' => 'string', 'length' => 4, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'product_request_number' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'kit_id' => ['type' => 'index', 'columns' => ['kit_id', 'product_request_year', 'product_request_number'], 'length' => []],
            'product_request_year' => ['type' => 'index', 'columns' => ['product_request_year', 'product_request_number'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'kits_product_requests_ibfk_1' => ['type' => 'foreign', 'columns' => ['kit_id'], 'references' => ['kits', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'kits_product_requests_ibfk_2' => ['type' => 'foreign', 'columns' => ['product_request_year', 'product_request_number'], 'references' => ['product_requests', '1' => ['year', 'number']], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'product_request_year' => 'Lo',
                'product_request_number' => 'Lorem ip',
                'amount' => 1,
                'created' => '2024-08-19 22:07:32',
                'modified' => '2024-08-19 22:07:32',
            ],
        ];
        parent::init();
    }
}
