<?php

declare(strict_types=1);

use Migrations\AbstractMigration;
use Cake\I18n\FrozenTime;

class InsertWorkplaces extends AbstractMigration
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
        $file = fopen('config/data/workplaces.csv', 'r');

        // Skip the header row if your CSV file has one
        fgetcsv($file);

        while (($row = fgetcsv($file, null, ',')) !== FALSE) {
            $data[] = [
                'description' => $row[0],
                'status' => true,
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ];
        }

        fclose($file);

        $table = $this->table('workplaces');
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
        $this->execute('TRUNCATE TABLE workplaces');
    }
}
