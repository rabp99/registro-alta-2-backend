<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReutilizablesSolicitudesDetalle Entity
 *
 * @property int $id
 * @property int $solicitud_id
 * @property int $reutilizable_id
 * @property string $dni_medico
 * @property \Cake\I18n\FrozenTime $fecha_entrega
 * @property \Cake\I18n\FrozenTime $fecha_vestuario
 * @property \Cake\I18n\FrozenTime $fecha_lavanderia
 * @property \Cake\I18n\FrozenTime $fecha_devolucion
 * @property int $estado_id
 * @property int $user_regisro_entrega_id
 * @property int|null $user_regisro_vestuario_id
 * @property int|null $user_regisro_lavanderia_id
 * @property int|null $user_regisro_devolucion_id
 *
 * @property \App\Model\Entity\Solicitud $solicitude
 * @property \App\Model\Entity\Reutilizable $reutilizable
 * @property \App\Model\Entity\Estado $estado
 */
class ReutilizablesSolicitudesDetalle extends Entity
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
        'fecha_entrega' => true,
        'fecha_vestuario' => true,
        'fecha_lavanderia' => true,
        'fecha_devolucion' => true,
        'solicitud' => true,
        'solicitud_id' => true,
        'reutilizable' => true,
        'reutilizable_id' => true,
        'estado' => true,
        'estado_id' => true
    ];
}
