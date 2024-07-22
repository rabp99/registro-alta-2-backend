<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Colaborador Entity
 *
 * @property int $id
 * @property string $tipo_documento
 * @property string $nro_documento
 * @property string $trabajador
 * @property string|null $grupo_ocupacional
 * @property int $estado_id
 *
 * @property \App\Model\Entity\Estado $estado
 */
class Colaborador extends Entity
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
        'tipo_documento' => true,
        'nro_documento' => true,
        'trabajador' => true,
        'grupo_ocupacional' => true,
        'estado' => true,
    ];
}
