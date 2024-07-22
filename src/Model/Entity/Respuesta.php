<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Respuesta Entity
 *
 * @property int $id
 * @property int $cuestionario_id
 * @property int $pregunta_id
 * @property string|null $valor
 *
 * @property \App\Model\Entity\Cuestionario $cuestionario
 * @property \App\Model\Entity\Pregunta $pregunta
 */
class Respuesta extends Entity
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
        'valor' => true,
        'cuestionario' => true,
        'pregunta' => true,
    ];
}
