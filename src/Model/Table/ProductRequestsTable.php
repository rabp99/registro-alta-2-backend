<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductRequests Model
 *
 * @property \App\Model\Table\WorkAreasTable&\Cake\ORM\Association\BelongsTo $WorkAreas
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ProductRequest newEmptyEntity()
 * @method \App\Model\Entity\ProductRequest newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ProductRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductRequest findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ProductRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductRequest[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductRequest|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductRequest saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductRequest[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductRequest[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductRequest[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductRequest[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductRequestsTable extends Table
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

        $this->setTable('product_requests');
        $this->setDisplayField(['year', 'number']);
        $this->setPrimaryKey(['year', 'number']);

        $this->addBehavior('Timestamp');

        $this->addBehavior('Base64FileUpload', [
            'origin_field' => 'signature',
            'dest_field' => 'signature_path',
            'path' => 'signatures',
        ]);

        $this->belongsTo('Workers', [
            'foreignKey' => ['document_type', 'document_number'],
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('WorkAreaDetails', [
            'foreignKey' => 'work_area_detail_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'handled_by_user_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('KitsProductRequests', [
            'foreignKey' => ['product_request_year', 'product_request_number'],
            'dependent' => true,
            'cascadeCallbacks' => true,
        ])->setBindingKey(['year', 'number']);
    }

    public function create(array $data)
    {
        $currentYear = date('Y');

        $lastRequest = $this->find()
            ->select(['number'])
            ->where(['year' => $currentYear])
            ->order(['number' => 'DESC'])
            ->first();

        $newNumber = $lastRequest ? $lastRequest->number + 1 : 1;

        $productRequest = $this->newEmptyEntity();
        $productRequest->year = $currentYear;
        $productRequest->number = $newNumber;

        $productRequest = $this->patchEntity($productRequest, $data, [
            'associated' => ['KitsProductRequests.ProductRequestDetails']
        ]);

        return $productRequest;
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
            ->scalar('year')
            ->maxLength('year', 4)
            ->allowEmptyString('year', null, 'create');

        $validator
            ->scalar('number')
            ->maxLength('number', 10)
            ->allowEmptyString('number', null, 'create');

        $validator
            ->scalar('document_type')
            ->maxLength('document_type', 5)
            ->notEmptyString('document_type');

        $validator
            ->scalar('document_number')
            ->maxLength('document_number', 8)
            ->requirePresence('document_number', 'create')
            ->notEmptyString('document_number');

        $validator
            ->dateTime('attention_date')
            ->allowEmptyDateTime('attention_date');

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
        $rules->add($rules->existsIn(['work_area_detail_id'], 'WorkAreaDetails'), ['errorField' => 'work_area_detail_id']);
        //$rules->add($rules->existsIn(['handled_by_user_id'], 'Users'), ['errorField' => 'handled_by_user_id']);

        return $rules;
    }
}
