<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Entrega Entity
 *
 * @property int $id
 * @property int $consumible_id
 * @property \Cake\I18n\FrozenDate $fecha
 * @property int|null $cantidad
 * @property string $tipo_documento
 * @property string $nro_documento
 * @property string $profesional
 *
 * @property \App\Model\Entity\Consumible $consumible
 */
class Entrega extends Entity
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
        'fecha' => true,
        'cantidad' => true,
        'tipo_documento' => true,
        'nro_documento' => true,
        'profesional' => true,
        'consumible' => true,
        'consumible_id' => true,
    ];
}
