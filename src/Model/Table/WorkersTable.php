<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Workers Model
 *
 * @property \App\Model\Table\WorkerOccupationalGroupsTable&\Cake\ORM\Association\BelongsTo $WorkerOccupationalGroups
 * @property \App\Model\Table\WorkerConditionsTable&\Cake\ORM\Association\BelongsTo $WorkerConditions
 * @property \App\Model\Table\WorkerMedicalSpecialitiesTable&\Cake\ORM\Association\BelongsTo $WorkerMedicalSpecialities
 *
 * @method \App\Model\Entity\Worker newEmptyEntity()
 * @method \App\Model\Entity\Worker newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Worker[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Worker get($primaryKey, $options = [])
 * @method \App\Model\Entity\Worker findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Worker patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Worker[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Worker|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Worker saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Worker[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Worker[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Worker[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Worker[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WorkersTable extends Table
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

        $this->setTable('workers');
        $this->setDisplayField('document_number');
        $this->setPrimaryKey(['document_type', 'document_number']);

        $this->addBehavior('Timestamp');
        $this->addBehavior('UserTrackable');

        $this->belongsTo('WorkerOccupationalGroups', [
            'foreignKey' => 'worker_occupational_group_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('WorkerConditions', [
            'foreignKey' => 'worker_condition_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('WorkerMedicalSpecialities', [
            'foreignKey' => 'worker_medical_speciality_id',
            'joinType' => 'INNER',
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
            ->scalar('document_type')
            ->maxLength('document_type', 5)
            ->allowEmptyString('document_type', null, 'create');

        $validator
            ->scalar('document_number')
            ->maxLength('document_number', 8)
            ->allowEmptyString('document_number', null, 'create');

        $validator
            ->scalar('last_name1')
            ->maxLength('last_name1', 60)
            ->requirePresence('last_name1', 'create')
            ->notEmptyString('last_name1');

        $validator
            ->scalar('last_name2')
            ->maxLength('last_name2', 60)
            ->requirePresence('last_name2', 'create')
            ->notEmptyString('last_name2');

        $validator
            ->scalar('names')
            ->maxLength('names', 60)
            ->requirePresence('names', 'create')
            ->notEmptyString('names');

        $validator
            ->scalar('tuition_code')
            ->maxLength('tuition_code', 10)
            ->allowEmptyString('tuition_code');

        $validator
            ->scalar('payroll_code')
            ->maxLength('payroll_code', 10)
            ->allowEmptyString('payroll_code');

        $validator
            ->scalar('belongs_other_cas')
            ->maxLength('belongs_other_cas', 10)
            ->requirePresence('belongs_other_cas', 'create')
            ->notEmptyString('belongs_other_cas');

        $validator
            ->date('birth_date')
            ->allowEmptyDate('birth_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['worker_occupational_group_id'], 'WorkerOccupationalGroups'), ['errorField' => 'worker_occupational_group_id']);
        $rules->add($rules->existsIn(['worker_condition_id'], 'WorkerConditions'), ['errorField' => 'worker_condition_id']);
        $rules->add($rules->existsIn(['worker_medical_speciality_id'], 'WorkerMedicalSpecialities'), ['errorField' => 'worker_medical_speciality_id']);

        return $rules;
    }
}
