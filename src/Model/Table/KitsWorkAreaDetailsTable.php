<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KitsWorkAreaDetails Model
 *
 * @property \App\Model\Table\KitsTable&\Cake\ORM\Association\BelongsTo $Kits
 * @property \App\Model\Table\WorkAreaDetailsTable&\Cake\ORM\Association\BelongsTo $WorkAreaDetails
 *
 * @method \App\Model\Entity\KitsWorkAreaDetail newEmptyEntity()
 * @method \App\Model\Entity\KitsWorkAreaDetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\KitsWorkAreaDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class KitsWorkAreaDetailsTable extends Table
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

        $this->setTable('kits_work_area_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Kits', [
            'foreignKey' => 'kit_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('WorkAreaDetails', [
            'foreignKey' => 'work_area_detail_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('amount')
            ->notEmptyString('amount');

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
        $rules->add($rules->existsIn(['kit_id'], 'Kits'), ['errorField' => 'kit_id']);
        $rules->add($rules->existsIn(['work_area_detail_id'], 'WorkAreaDetails'), ['errorField' => 'work_area_detail_id']);

        return $rules;
    }
}
