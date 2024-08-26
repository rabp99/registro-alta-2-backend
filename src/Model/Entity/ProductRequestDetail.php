<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductRequestDetail Entity
 *
 * @property int $id
 * @property int $kits_product_request_id
 * @property int $product_id
 * @property int $amount
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\KitsProductRequest $kits_product_request
 * @property \App\Model\Entity\Product $product
 */
class ProductRequestDetail extends Entity
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
        'kits_product_request_id' => true,
        'product_id' => true,
        'amount' => true,
        'created' => true,
        'modified' => true,
        'kits_product_request' => true,
        'product' => true,
    ];
}
