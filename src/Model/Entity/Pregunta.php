<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pregunta Entity
 *
 * @property int $id
 * @property int $nro
 * @property string $descripcion
 * @property int $grupo_id
 * @property int $estado_id
 *
 * @property \App\Model\Entity\Grupo $grupo
 * @property \App\Model\Entity\Estado $estado
 */
class Pregunta extends Entity
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
        'nro' => true,
        'descripcion' => true,
        'grupo' => true,
        'estado' => true,
    ];
}
