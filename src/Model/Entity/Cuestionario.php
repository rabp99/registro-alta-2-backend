<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cuestionario Entity
 *
 * @property int $id
 * @property string $programacion_centro
 * @property string $programacion_dni_medico
 * @property \Cake\I18n\FrozenDate $programacion_fecha_programacion
 * @property string $programacion_turno
 * @property \Cake\I18n\FrozenTime $fecha_hora
 * @property string $supervisor_dni
 * @property string $supervisor_nombres
 */
class Cuestionario extends Entity
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
        'fecha_hora' => true,
        'supervisor_dni' => true,
        'supervisor_nombres' => true,
        'observaciones' => true,
        
        'programacion_centro' => true,
        'programacion_dni_medico' => true,
        'programacion_fecha_programacion' => true,
        'programacion_turno' => true
    ];
}
