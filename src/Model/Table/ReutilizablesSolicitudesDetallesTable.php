<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReutilizablesSolicitudesDetalles Model
 *
 * @property \App\Model\Table\SolicitudesTable&\Cake\ORM\Association\BelongsTo $Solicitudes
 * @property \App\Model\Table\ReutilizablesTable&\Cake\ORM\Association\BelongsTo $Reutilizables
 * @property \App\Model\Table\EstadosTable&\Cake\ORM\Association\BelongsTo $Estados
 *
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle newEmptyEntity()
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ReutilizablesSolicitudesDetalle[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ReutilizablesSolicitudesDetallesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('reutilizables_solicitudes_detalles');
        $this->setDisplayField('fecha');
        $this->setPrimaryKey('id');

        $this->belongsTo('Solicitudes', [
            'foreignKey' => 'solicitud_id',
            'joinType' => 'INNER',
        ])->setProperty('solicitud');
        
        $this->belongsTo('Reutilizables', [
            'foreignKey' => 'reutilizable_id',
            'joinType' => 'INNER',
        ]);
        
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER',
        ]);
        
        $this->belongsTo('EntregaUsers', [
            'foreignKey' => 'user_registro_entrega_id',
            'joinType' => 'LEFT',
        ])->setClassName('Users');
        
        $this->belongsTo('VestuarioUsers', [
            'foreignKey' => 'user_registro_vestuario_id',
            'joinType' => 'LEFT',
        ])->setClassName('Users');
        
        $this->belongsTo('LavanderiaUsers', [
            'foreignKey' => 'user_registro_lavanderia_id',
            'joinType' => 'LEFT',
        ])->setClassName('Users');
        
        $this->belongsTo('DevolucionUsers', [
            'foreignKey' => 'user_registro_devolucion_id',
            'joinType' => 'LEFT',
        ])->setClassName('Users');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->date('fecha_entrega')
            ->requirePresence('fecha_entrega', 'create')
            ->notEmptyDateTime('fecha_entrega');

        $validator
            ->date('fecha_vestuario')
            ->requirePresence('fecha_vestuario', 'create')
            ->allowEmptyDateTime('fecha_vestuario');

        $validator
            ->date('fecha_lavanderia')
            ->requirePresence('fecha_lavanderia', 'create')
            ->allowEmptyDateTime('fecha_lavanderia');

        $validator
            ->date('fecha_devolucion')
            ->requirePresence('fecha_devolucion', 'create')
            ->allowEmptyDateTime('fecha_devolucion');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn(['solicitud_id'], 'Solicitudes'), ['errorField' => 'solicitud_id']);
        $rules->add($rules->existsIn(['reutilizable_id'], 'Reutilizables'), ['errorField' => 'reutilizable_id']);
        $rules->add($rules->existsIn(['estado_id'], 'Estados'), ['errorField' => 'estado_id']);

        return $rules;
    }
}
