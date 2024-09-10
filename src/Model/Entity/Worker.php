<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Worker Entity
 *
 * @property string $document_type
 * @property string $document_number
 * @property int $worker_occupational_group_id
 * @property int $worker_condition_id
 * @property string $last_name1
 * @property string $last_name2
 * @property string $names
 * @property string|null $tuition_code
 * @property string|null $payroll_code
 * @property string $belongs_other_cas
 * @property int $worker_medical_speciality_id
 * @property \Cake\I18n\FrozenDate|null $birth_date
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\WorkerOccupationalGroup $worker_occupational_group
 * @property \App\Model\Entity\WorkerCondition $worker_condition
 * @property \App\Model\Entity\WorkerMedicalSpeciality $worker_medical_speciality
 */
class Worker extends Entity
{
    protected $_virtual = ['document', 'full_name'];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'document_type' => true,
        'document_number' => true,
        'worker_occupational_group_id' => true,
        'worker_condition_id' => true,
        'last_name1' => true,
        'last_name2' => true,
        'names' => true,
        'tuition_code' => true,
        'payroll_code' => true,
        'belongs_other_cas' => true,
        'worker_medical_speciality_id' => true,
        'birth_date' => true,
        'type_asistencial' => true,
        'type_administrativo' => true,
        'created' => true,
        'modified' => true,
        'worker_occupational_group' => true,
        'worker_condition' => true,
        'worker_medical_speciality' => true,
    ];

    protected function _getFullName()
    {
        return $this->last_name1 . " " . $this->last_name2 . ", " . $this->names;
    }

    protected function _getDocument()
    {
        return $this->document_type . ": " . $this->document_number;
    }
}
