<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HistorialConsumible Entity
 *
 * @property int $id
 * @property int $consumible_id
 * @property string|null $tipo
 * @property \Cake\I18n\FrozenTime $fecha_hora
 * @property int|null $cantidad
 * @property int|null $entrega_id
 *
 * @property \App\Model\Entity\Consumible $consumible
 * @property \App\Model\Entity\Entrega $entrega
 */
class HistorialConsumible extends Entity
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
        'tipo' => true,
        'fecha_hora' => true,
        'cantidad' => true,
        'entrega_id' => true,
        'consumible' => true,
        'consumible_id' => true,
        'entrega' => true,
        'entrega_id' => true,
    ];
}
