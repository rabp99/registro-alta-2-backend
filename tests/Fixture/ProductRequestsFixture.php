<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductRequestsFixture
 */
class ProductRequestsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'year' => ['type' => 'string', 'length' => 4, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'number' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'document_type' => ['type' => 'string', 'length' => 5, 'null' => false, 'default' => 'DNI', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'document_number' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'work_area_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'handled_by_user_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'attention_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'year' => ['type' => 'index', 'columns' => ['year', 'number', 'document_type', 'document_number', 'work_area_id', 'handled_by_user_id'], 'length' => []],
            'document_type' => ['type' => 'index', 'columns' => ['document_type', 'document_number'], 'length' => []],
            'work_area_id' => ['type' => 'index', 'columns' => ['work_area_id'], 'length' => []],
            'handled_by_user_id' => ['type' => 'index', 'columns' => ['handled_by_user_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['year', 'number'], 'length' => []],
            'product_requests_ibfk_1' => ['type' => 'foreign', 'columns' => ['document_type', 'document_number'], 'references' => ['workers', '1' => ['document_type', 'document_number']], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'product_requests_ibfk_2' => ['type' => 'foreign', 'columns' => ['work_area_id'], 'references' => ['work_areas', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'product_requests_ibfk_3' => ['type' => 'foreign', 'columns' => ['handled_by_user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'year' => '56c223a9-5f45-4ec7-b6cd-e34c44777cda',
                'number' => 'e58116cd-4899-48af-aa11-2ab28e2e5c72',
                'document_type' => 'Lor',
                'document_number' => 'Lorem ',
                'work_area_id' => 1,
                'created' => '2024-08-19 22:07:28',
                'modified' => '2024-08-19 22:07:28',
                'handled_by_user_id' => 1,
                'attention_date' => '2024-08-19 22:07:28',
            ],
        ];
        parent::init();
    }
}
