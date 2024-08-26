<?php

declare(strict_types=1);

use Migrations\AbstractMigration;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

class InsertWorkAreaDetails extends AbstractMigration
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
        $file = fopen('config/data/work_area_details.csv', 'r');

        // Skip the header row if your CSV file has one
        fgetcsv($file);

        while (($row = fgetcsv($file, null, ';')) !== FALSE) {
            $workAreaId = $this->getWorkAreaId($row[1], $row[2]);

            $data[] = [
                'description' => $row[0],
                'work_area_id' => $workAreaId,
                'status' => true,
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ];
        }

        fclose($file);

        $table = $this->table('work_area_details');
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
        $this->execute('TRUNCATE TABLE work_area_details');
    }

    public function getWorkAreaId($workAreaDescription, $workplaceDescription)
    {
        $workAreasTable = TableRegistry::getTableLocator()->get('work_areas');
        $workplacesTable = TableRegistry::getTableLocator()->get('workplaces');

        $workplace = $workplacesTable->find()
            ->where(["workplaces.description" => $workplaceDescription])
            ->first();

        $workArea = $workAreasTable->find()
            ->where([
                "work_areas.workplace_id" => $workplace->id,
                "work_areas.description" => $workAreaDescription
            ])
            ->first();

        return $workArea->id;
    }
}
