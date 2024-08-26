<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KitsWorkAreaDetail Entity
 *
 * @property int $id
 * @property int $kit_id
 * @property int $work_area_detail_id
 * @property int $amount
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Kit $kit
 * @property \App\Model\Entity\WorkAreaDetail $work_area_detail
 */
class KitsWorkAreaDetail extends Entity
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
        'kit_id' => true,
        'work_area_detail_id' => true,
        'amount' => true,
        'created' => true,
        'modified' => true,
        'kit' => true,
        'work_area_detail' => true,
    ];
}
