<?php

declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Datasource\EntityInterface;

/**
 * UserTrackable behavior
 */
class UserTrackableBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'createdByField' => 'created_by',
        'modifiedByField' => 'modified_by',
    ];

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        // Verificar si se pasó el userId en las opciones
        $userId = $options['userId'] ?? null;

        if ($userId) {
            // Si es un nuevo registro, agregar created_by
            if ($entity->isNew() && $this->_config['createdByField']) {
                $entity->set($this->_config['createdByField'], $userId);
            }

            // Siempre actualizar el modified_by
            if ($this->_config['modifiedByField']) {
                $entity->set($this->_config['modifiedByField'], $userId);
            }
        }
    }
}
