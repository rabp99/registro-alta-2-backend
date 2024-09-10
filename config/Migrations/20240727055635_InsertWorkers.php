<?php

declare(strict_types=1);

use Cake\I18n\FrozenDate;
use Migrations\AbstractMigration;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;

class InsertWorkers extends AbstractMigration
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
        $file = fopen('config/data/workers2.csv', 'r');

        // Skip the header row if your CSV file has one
        fgetcsv($file);

        while (($row = fgetcsv($file, null, ';')) !== FALSE) {
            $documentType = $this->getDocumentType($row[0]);
            $workerOccupationalGroup = $this->getWorkerOccupationalGroup($row[2]);
            $workerConditionId = $this->getWorkerConditionId($row[3]);
            $tuitionCode = $this->getTuitionCode($row[7]);
            $payrollCode = $this->getPayrollCode($row[8]);
            $belongsOtherCas = $this->getBelongsOtherCas($row[9]);
            $workerMedicalSpecialityId = $this->getWorkerMedicalSpecialityId($row[10]);
            $birthDate = $this->getBirthDate($row[11]);

            $typeAsistencial = $workerOccupationalGroup->type === "ASISTENCIAL";
            $typeAdministrativo = $workerOccupationalGroup->type === "ADMINISTRATIVO";

            $data[] = [
                'document_type' => $documentType,
                'document_number' => $row[1],
                'worker_occupational_group_id' => $workerOccupationalGroup->id,
                'worker_condition_id' => $workerConditionId,
                'last_name1' => $row[4],
                'last_name2' => $row[5],
                'names' => $row[6],
                'tuition_code' => $tuitionCode,
                'payroll_code' => $payrollCode,
                'belongs_other_cas' => $belongsOtherCas,
                'worker_medical_speciality_id' => $workerMedicalSpecialityId,
                'birth_date' => $birthDate,
                'type_asistencial' => $typeAsistencial,
                'type_administrativo' => $typeAdministrativo,
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ];
        }

        fclose($file);

        $table = $this->table('workers');
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
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('TRUNCATE TABLE workers');
        $this->execute('TRUNCATE TABLE worker_medical_specialities');
        $this->execute('TRUNCATE TABLE worker_conditions');
        $this->execute('TRUNCATE TABLE worker_occupational_groups');
        $this->execute('SET foreign_key_checks = 1');
    }

    public function getDocumentType($data)
    {
        $documentType = null;
        if ($data === "1") {
            $documentType = "DNI";
        } elseif ($data === "2") {
            $documentType = "CE";
        }
        return $documentType ?? "DNI";
    }

    public function getWorkerOccupationalGroup($data)
    {
        $workerOccupationalGroupsTable = TableRegistry::getTableLocator()->get('worker_occupational_groups');

        $workerOccupationalGroup = $workerOccupationalGroupsTable->findOrCreate(
            [
                "description" => $data,
            ],
            function ($workerOccupationalGroup) use ($data) {
                $workerOccupationalGroup->description = $data;
                $workerOccupationalGroup->status = true;
                $workerOccupationalGroup->created = FrozenTime::now();
                $workerOccupationalGroup->modified = FrozenTime::now();
            }
        );

        return $workerOccupationalGroup;
    }

    public function getWorkerConditionId($data)
    {
        $workerConditionsTable = TableRegistry::getTableLocator()->get('worker_conditions');

        $workerCondition = $workerConditionsTable->findOrCreate(
            [
                "description" => $data,
            ],
            function ($workerCondition) use ($data) {
                $workerCondition->description = $data;
                $workerCondition->status = true;
                $workerCondition->created = FrozenTime::now();
                $workerCondition->modified = FrozenTime::now();
            }
        );

        return $workerCondition->id;
    }

    public function getTuitionCode($data)
    {
        if ($data === "") {
            return null;
        }
        return $data;
    }

    public function getPayrollCode($data)
    {
        if ($data === "") {
            return null;
        }
        return $data;
    }

    public function getBelongsOtherCas($data)
    {
        $belongsOtherCas = $data;
        if ($data === "INACTIVOS") {
            $belongsOtherCas = "NO";
        }

        return $belongsOtherCas;
    }

    public function getWorkerMedicalSpecialityId($data)
    {
        if ($data === "") {
            $data = "SIN ESPECIALIDAD";
        }

        $workerMedicalSpecialitiesTable = TableRegistry::getTableLocator()->get('worker_medical_specialities');

        $workerMedicalSpeciality = $workerMedicalSpecialitiesTable->findOrCreate(
            [
                "description" => $data,
            ],
            function ($workerMedicalSpeciality) use ($data) {
                $workerMedicalSpeciality->description = $data;
                $workerMedicalSpeciality->status = true;
                $workerMedicalSpeciality->created = FrozenTime::now();
                $workerMedicalSpeciality->modified = FrozenTime::now();
            }
        );

        return $workerMedicalSpeciality->id;
    }

    private function getBirthDate($data)
    {
        if (!$data) {
            return null;
        }

        $date = FrozenDate::createFromFormat('d/m/Y', $data);

        return $date->format('Y-m-d');
    }
}
