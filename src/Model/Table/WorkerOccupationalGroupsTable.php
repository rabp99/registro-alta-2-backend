<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WorkerOccupationalGroups Model
 *
 * @property \App\Model\Table\WorkersTable&\Cake\ORM\Association\HasMany $Workers
 *
 * @method \App\Model\Entity\WorkerOccupationalGroup newEmptyEntity()
 * @method \App\Model\Entity\WorkerOccupationalGroup newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkerOccupationalGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WorkerOccupationalGroupsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('worker_occupational_groups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('UserTrackable');

        $this->hasMany('Workers', [
            'foreignKey' => 'worker_occupational_group_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('description')
            ->maxLength('description', 60)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        return $validator;
    }
}
