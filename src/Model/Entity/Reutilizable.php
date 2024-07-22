<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reutilizable Entity
 *
 * @property int $id
 * @property int $tipo_id
 * @property int $estado_id
 * @property int $codigo
 *
 * @property \App\Model\Entity\Tipo $tipo
 * @property \App\Model\Entity\Estado $estado
 */
class Reutilizable extends Entity
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
        'codigo' => true,
        'tipo' => true,
        'estado' => true,
    ];
}
