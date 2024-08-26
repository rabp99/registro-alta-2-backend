<?php

declare(strict_types=1);

use Migrations\AbstractMigration;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;

class InsertKitsWorkAreaDetails extends AbstractMigration
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
        $file = fopen('config/data/kits_work_area_details.csv', 'r');

        // Skip the header row if your CSV file has one
        fgetcsv($file);

        while (($row = fgetcsv($file, null, ';')) !== FALSE) {
            $kitId = $this->getKitId($row[0]);
            $workAreaDetailId = $this->getWorkAreaDetailId($row[1], $row[2], $row[3]);

            $data[] = [
                'kit_id' => $kitId,
                'work_area_detail_id' => $workAreaDetailId,
                'amount' => $row[4],
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ];
        }

        fclose($file);

        $table = $this->table('kits_work_area_details');
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
        $this->execute('TRUNCATE TABLE kits_work_areas');
    }

    public function getKitId($data)
    {
        $kitsTable = TableRegistry::getTableLocator()->get('kits');

        $kit = $kitsTable->find()
            ->where(["kits.description" => $data])
            ->first();

        return $kit->id;
    }

    public function getWorkAreaDetailId($workAreaDetailDescription, $workAreaDescription, $workplaceDescription)
    {
        $workAreaDetailsTable = TableRegistry::getTableLocator()->get('work_area_details');
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

        $workAreaDetail = $workAreaDetailsTable->find()
            ->where([
                "work_area_details.work_area_id" => $workArea->id,
                "work_area_details.description" => $workAreaDetailDescription
            ])
            ->first();

        return $workAreaDetail->id;
    }
}
