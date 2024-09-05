<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductRequest Entity
 *
 * @property string $year
 * @property string $number
 * @property string $document_type
 * @property string $document_number
 * @property int $work_area_detail_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $handled_by_user_id
 * @property \Cake\I18n\FrozenTime|null $attention_date
 * @property string $signature
 *
 * @property \App\Model\Entity\WorkAreaDetail $work_area_detail
 * @property \App\Model\Entity\User $user
 */
class ProductRequest extends Entity
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
        'document_type' => true,
        'document_number' => true,
        'work_area_detail_id' => true,
        'created' => true,
        'modified' => true,
        'handled_by_user_id' => true,
        'attention_date' => true,
        'signature' => true,
        'signature_path' => true,
        'work_area_detail' => true,
        'user' => true,
        'kits_product_requests' => true,
    ];

    protected $_virtual = ['code'];

    protected function _getCode()
    {
        return $this->year . "-" . str_pad(strval($this->number), 4, "0", STR_PAD_LEFT);
    }
}
