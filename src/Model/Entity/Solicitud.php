<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Solicitud Entity
 *
 * @property int $id
 * @property string|null $programaciones_centro
 * @property int|null $programaciones_trabajador_id
 * @property \Cake\I18n\FrozenDate|null $programaciones_fecha_programacion
 * @property string|null $programaciones_turno
 * @property string $area_ingreso
 * @property string $tipo_epp
 * @property int $cantidad
 * @property \Cake\I18n\FrozenTime $fecha_solicitud
 * @property \Cake\I18n\FrozenTime|null $fecha_entrega
 * @property string|null $firma
 * @property int $estado_id
 * @property string $profesional
 * @property string|null $grupo_ocupacional
 * @property string|null $cod_planilla
 * @property int|null $user_entrega_id
 *
 * @property \App\Model\Entity\Programacion $programacion
 * @property \App\Model\Entity\Estado $estado
 */
class Solicitud extends Entity
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
        'programacion_centro' => true,
        'programacion_dni_medico' => true,
        'programacion_fecha_programacion' => true,
        'programacion_turno' => true,
        'area_ingreso' => true,
        'tipo_epp' => true,
        'cantidad' => true,
        'fecha_solicitud' => true,
        'fecha_entrega' => true,
        'firma' => true,
        'programacion' => true,
        'estado' => true,
        'estado_id' => true,
        'profesional' => true,
        'grupo_ocupacional' => true,
        'cod_planilla' => true,
    ];
}
