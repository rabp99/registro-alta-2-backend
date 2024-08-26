<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WorkAreaDetail Entity
 *
 * @property int $id
 * @property string $description
 * @property int $work_area_id
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\WorkArea $work_area
 * @property \App\Model\Entity\Kit[] $kits
 */
class WorkAreaDetail extends Entity
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
        'work_area_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'work_area' => true,
        'kits' => true,
    ];
}
