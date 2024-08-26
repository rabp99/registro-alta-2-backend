<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WorkArea Entity
 *
 * @property int $id
 * @property string $description
 * @property int $workplace_id
 * @property bool $type_asistencial
 * @property bool $type_administrativo
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Workplace $workplace
 */
class WorkArea extends Entity
{
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
        'description' => true,
        'workplace_id' => true,
        'type_asistencial' => true,
        'type_administrativo' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'workplace' => true,
    ];
}
