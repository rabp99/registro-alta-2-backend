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
 * @property int $estado_id
 * @property int $grupo_ocupacional_id
 *
 * @property \App\Model\Entity\Estado $estado
 * @property \App\Model\Entity\GruposOcupacional $grupo_ocupacional
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
        'dni_medico' => true,
        'nombre_completo' => true,
        'cod_planilla' => true,
        'grupo_ocupacional' => true,
        'grupo_ocupacional_id' => true,
        'estado' => true,
    ];
}
