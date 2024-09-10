<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WorkerMedicalSpecialities Model
 *
 * @property \App\Model\Table\WorkersTable&\Cake\ORM\Association\HasMany $Workers
 *
 * @method \App\Model\Entity\WorkerMedicalSpeciality newEmptyEntity()
 * @method \App\Model\Entity\WorkerMedicalSpeciality newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality get($primaryKey, $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkerMedicalSpeciality[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WorkerMedicalSpecialitiesTable extends Table
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

        $this->setTable('worker_medical_specialities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('UserTrackable');

        $this->hasMany('Workers', [
            'foreignKey' => 'worker_medical_speciality_id',
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
