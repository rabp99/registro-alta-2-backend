<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KitsProductRequests Model
 *
 * @property \App\Model\Table\KitsTable&\Cake\ORM\Association\BelongsTo $Kits
 *
 * @method \App\Model\Entity\KitsProductRequest newEmptyEntity()
 * @method \App\Model\Entity\KitsProductRequest newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\KitsProductRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KitsProductRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\KitsProductRequest findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\KitsProductRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KitsProductRequest[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\KitsProductRequest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KitsProductRequest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KitsProductRequest[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\KitsProductRequest[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\KitsProductRequest[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\KitsProductRequest[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class KitsProductRequestsTable extends Table
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

        $this->setTable('kits_product_requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('UserTrackable');

        $this->belongsTo('Kits', [
            'foreignKey' => 'kit_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('ProductRequests', [
            'foreignKey' => ["product_request_year", "product_request_number"],
            'joinType' => 'INNER',
        ]);

        $this->hasMany('ProductRequestDetails', [
            'foreignKey' => 'kits_product_request_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ])->setBindingKey('id');
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

        return $rules;
    }
}
