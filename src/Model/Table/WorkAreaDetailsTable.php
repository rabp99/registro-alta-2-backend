<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WorkAreaDetails Model
 *
 * @property \App\Model\Table\WorkAreasTable&\Cake\ORM\Association\BelongsTo $WorkAreas
 * @property \App\Model\Table\KitsTable&\Cake\ORM\Association\BelongsToMany $Kits
 *
 * @method \App\Model\Entity\WorkAreaDetail newEmptyEntity()
 * @method \App\Model\Entity\WorkAreaDetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\WorkAreaDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WorkAreaDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\WorkAreaDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\WorkAreaDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WorkAreaDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\WorkAreaDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkAreaDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkAreaDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkAreaDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkAreaDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkAreaDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WorkAreaDetailsTable extends Table
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

        $this->setTable('work_area_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('UserTrackable');

        $this->belongsTo('WorkAreas', [
            'foreignKey' => 'work_area_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Kits', [
            'foreignKey' => 'work_area_detail_id',
            'targetForeignKey' => 'kit_id',
            'joinTable' => 'kits_work_area_details',
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
            ->maxLength('description', 200)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

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
        $rules->add($rules->existsIn(['work_area_id'], 'WorkAreas'), ['errorField' => 'work_area_id']);

        return $rules;
    }
}
