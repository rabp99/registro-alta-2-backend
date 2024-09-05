<?php

declare(strict_types=1);

use Migrations\AbstractMigration;
use Cake\I18n\FrozenTime;

class InsertParameters extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $data = [];
        $data[] = [
            'key' => 'responsible.full_name',
            'description' => 'Nombres y Apellidos',
            'visible' => true,
            'created' => FrozenTime::now(),
            'modified' => FrozenTime::now(),
        ];

        $data[] = [
            'key' => 'responsible.job_position',
            'description' => 'Cargo',
            'visible' => true,
            'created' => FrozenTime::now(),
            'modified' => FrozenTime::now(),
        ];

        $data[] = [
            'key' => 'responsible.signature',
            'description' => 'Firma',
            'visible' => true,
            'created' => FrozenTime::now(),
            'modified' => FrozenTime::now(),
        ];

        $data[] = [
            'key' => 'reports.product_requests_records.record_number',
            'description' => 'N° REGISTRO',
            'visible' => false,
            'created' => FrozenTime::now(),
            'modified' => FrozenTime::now(),
        ];

        $table = $this->table('parameters');
        $table->insert($data)->saveData();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function down()
    {
        $this->execute('TRUNCATE TABLE parameters');
    }
}
