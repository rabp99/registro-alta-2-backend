<?php

declare(strict_types=1);

use Cake\I18n\FrozenDate;
use Migrations\AbstractMigration;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

class InsertWorkerOccupationalGroups extends AbstractMigration
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
        $file = fopen('config/data/worker_occupational_groups.csv', 'r');

        // Skip the header row if your CSV file has one
        fgetcsv($file);

        while (($row = fgetcsv($file, null, ',')) !== FALSE) {
            $data[] = [
                'description' => $row[0],
                'type' => $row[1],
                'status' => true,
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ];
        }

        fclose($file);

        $table = $this->table('worker_occupational_groups');
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
        $this->execute('TRUNCATE TABLE worker_occupational_groups');
    }
}
