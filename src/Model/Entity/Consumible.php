<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Consumible Entity
 *
 * @property int $id
 * @property string $descripcion
 * @property string|null $marca
 * @property int $stock
 * @property int $estado_id
 *
 * @property \App\Model\Entity\Estado $estado
 */
class Consumible extends Entity
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
        'descripcion' => true,
        'marca' => true,
        'stock' => true,
        'estado' => true,
    ];
    
    protected $_virtual = ['descripcion_for_list'];
    
    protected function _getDescripcionForList() {
        $descripcionForList = $this->descripcion;
        if ($this->marca) {
            $descripcionForList .= ' | ' . $this->marca;
        }
        return $descripcionForList;
    }
}
