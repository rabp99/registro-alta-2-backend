<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CuadroResuman Entity
 *
 * @property int|null $user_entrega_id
 * @property \Cake\I18n\FrozenDate|null $fecha_entrega_date_solicitud
 * @property string $nombre_completo
 * @property string $username
 * @property string|null $epp_0
 * @property string|null $epp_2
 * @property string|null $epp_5
 * @property string|null $epp_8
 * @property string|null $respiradores
 * @property string|null $n95
 * @property string|null $lentes
 * @property string|null $filtros
 * @property string|null $mandilones_tela
 * @property string|null $pantalones_tela
 * @property string|null $chaquetas_tela
 *
 * @property \App\Model\Entity\UserEntrega $user_entrega
 */
class CuadroResuman extends Entity
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
        'user_entrega_id' => true,
        'fecha_entrega_date_solicitud' => true,
        'nombre_completo' => true,
        'username' => true,
        'epp_0' => true,
        'epp_2' => true,
        'epp_5' => true,
        'epp_8' => true,
        'respiradores' => true,
        'n95' => true,
        'lentes' => true,
        'filtros' => true,
        'mandilones_tela' => true,
        'pantalones_tela' => true,
        'chaquetas_tela' => true,
        'user_entrega' => true,
    ];
}
