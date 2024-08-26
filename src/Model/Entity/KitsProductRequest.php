<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KitsProductRequest Entity
 *
 * @property int $id
 * @property int $kit_id
 * @property string $product_request_year
 * @property string $product_request_number
 * @property int $amount
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Kit $kit
 */
class KitsProductRequest extends Entity
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
        'product_request_year' => true,
        'product_request_number' => true,
        'amount' => true,
        'created' => true,
        'modified' => true,
        'kit' => true,
        'product_request_details' => true
    ];
}
