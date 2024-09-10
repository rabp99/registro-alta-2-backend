<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WorkAreas Model
 *
 * @property \App\Model\Table\WorkplacesTable&\Cake\ORM\Association\BelongsTo $Workplaces
 *
 * @method \App\Model\Entity\WorkArea newEmptyEntity()
 * @method \App\Model\Entity\WorkArea newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\WorkArea[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WorkArea get($primaryKey, $options = [])
 * @method \App\Model\Entity\WorkArea findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\WorkArea patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WorkArea[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\WorkArea|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkArea saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WorkArea[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkArea[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkArea[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\WorkArea[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WorkAreasTable extends Table
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

        $this->setTable('work_areas');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('UserTrackable');

        $this->belongsTo('Workplaces', [
            'foreignKey' => 'workplace_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsToMany('Kits', [
            'foreignKey' => 'work_area_id',
            'targetForeignKey' => 'kit_id',
            'joinTable' => 'kits_work_areas'
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
            ->maxLength('description', 150)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->boolean('type_asistencial')
            ->requirePresence('type_asistencial', 'create')
            ->notEmptyString('type_asistencial');

        $validator
            ->boolean('type_administrativo')
            ->requirePresence('type_administrativo', 'create')
            ->notEmptyString('type_administrativo');

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
        $rules->add($rules->existsIn(['workplace_id'], 'Workplaces'), ['errorField' => 'workplace_id']);

        return $rules;
    }
}
