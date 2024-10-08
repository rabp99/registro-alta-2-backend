<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Workplace Entity
 *
 * @property int $id
 * @property int $description
 * @property string $type
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Workplace extends Entity
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
        'type_asistencial' => true,
        'type_administrativo' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
    ];
}
