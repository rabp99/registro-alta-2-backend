<?php

declare(strict_types=1);

use Migrations\AbstractMigration;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

class InsertWorkAreas extends AbstractMigration
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
        $file = fopen('config/data/work_areas.csv', 'r');

        // Skip the header row if your CSV file has one
        fgetcsv($file);

        while (($row = fgetcsv($file, null, ';')) !== FALSE) {
            $workplaceId = $this->getWorkplaceId($row[1]);

            $data[] = [
                'description' => $row[0],
                'workplace_id' => $workplaceId,
                'type_asistencial' => $row[2],
                'type_administrativo' => $row[3],
                'status' => true,
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ];
        }

        fclose($file);

        $table = $this->table('work_areas');
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
        $this->execute('TRUNCATE TABLE work_areas');
    }

    public function getWorkplaceId($data)
    {
        $workplacesTable = TableRegistry::getTableLocator()->get('workplaces');

        $workplace = $workplacesTable->find()
            ->where(["workplaces.description" => $data])
            ->first();

        return $workplace->id;
    }
}
