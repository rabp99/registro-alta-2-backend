<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Programacion Entity
 *
 * @property string $centro
 * @property string $periodo
 * @property string $area
 * @property string $servicio
 * @property string $actividad
 * @property string $subactividad
 * @property string|null $consultorio
 * @property string|null $ubicacionconsult
 * @property string|null $grupo_ocupacional
 * @property string|null $tip_programacion
 * @property \Cake\I18n\FrozenDate $fecha_programacion
 * @property string|null $hor_inicio
 * @property string|null $hor_fin
 * @property string|null $estado_programacion
 * @property string $turno
 * @property string|null $condtrabajador
 * @property string|null $pertenece_otro_cas
 * @property \Cake\I18n\FrozenTime $fecha_hora_entrada
 * @property \Cake\I18n\FrozenTime $fecha_hora_salida
 * @property Estado $estado
 * @property Trabajador $trabajador
 */
class Programacion extends Entity
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
        'periodo' => true,
        'area' => true,
        'servicio' => true,
        'actividad' => true,
        'subactividad' => true,
        'consultorio' => true,
        'ubicacionconsult' => true,
        'grupo_ocupacional' => true,
        'tip_programacion' => true,
        'hor_inicio' => true,
        'hor_fin' => true,
        'estado_programacion' => true,
        'condtrabajador' => true,
        'pertenece_otro_cas' => true,
        'fecha_hora_entrada' => true,
        'fecha_hora_salida' => true,
        'flag_interno' => true,
        'estado' => true,
        'estado_id' => true,
        'trabajador' => true,
        'dni_medico' => true,
    ];
}
