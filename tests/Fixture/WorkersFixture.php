<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WorkersFixture
 */
class WorkersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'document_type' => ['type' => 'string', 'length' => 5, 'null' => false, 'default' => 'DNI', 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'document_number' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'worker_occupational_group_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'worker_condition_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'last_name1' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'last_name2' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'names' => ['type' => 'string', 'length' => 60, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'tuition_code' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'payroll_code' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'belongs_other_cas' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null],
        'worker_medical_speciality_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'birth_date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'worker_occupational_group_id' => ['type' => 'index', 'columns' => ['worker_occupational_group_id', 'worker_condition_id', 'worker_medical_speciality_id'], 'length' => []],
            'worker_condition_id' => ['type' => 'index', 'columns' => ['worker_condition_id'], 'length' => []],
            'worker_medical_speciality_id' => ['type' => 'index', 'columns' => ['worker_medical_speciality_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['document_type', 'document_number'], 'length' => []],
            'workers_ibfk_1' => ['type' => 'foreign', 'columns' => ['worker_occupational_group_id'], 'references' => ['worker_occupational_groups', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'workers_ibfk_2' => ['type' => 'foreign', 'columns' => ['worker_condition_id'], 'references' => ['worker_conditions', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'workers_ibfk_3' => ['type' => 'foreign', 'columns' => ['worker_medical_speciality_id'], 'references' => ['worker_medical_specialities', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'document_type' => '6deb26a3-b069-4869-bf2a-ebbf9b1ee7ec',
                'document_number' => '42347166-e3fc-47b8-85c3-26e71993540b',
                'worker_occupational_group_id' => 1,
                'worker_condition_id' => 1,
                'last_name1' => 'Lorem ipsum dolor sit amet',
                'last_name2' => 'Lorem ipsum dolor sit amet',
                'names' => 'Lorem ipsum dolor sit amet',
                'tuition_code' => 'Lorem ip',
                'payroll_code' => 'Lorem ip',
                'belongs_other_cas' => 'Lorem ip',
                'worker_medical_speciality_id' => 1,
                'birth_date' => '2024-07-30',
                'created' => '2024-07-30 01:06:09',
                'modified' => '2024-07-30 01:06:09',
            ],
        ];
        parent::init();
    }
}
