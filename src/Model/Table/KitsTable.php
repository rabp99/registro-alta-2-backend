<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Kits Model
 *
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsToMany $Products
 * @property \App\Model\Table\WorkAreasTable&\Cake\ORM\Association\BelongsToMany $WorkAreas
 *
 * @method \App\Model\Entity\Kit newEmptyEntity()
 * @method \App\Model\Entity\Kit newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Kit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Kit get($primaryKey, $options = [])
 * @method \App\Model\Entity\Kit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Kit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Kit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Kit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Kit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Kit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Kit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Kit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Kit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class KitsTable extends Table
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

        $this->setTable('kits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Products', [
            'foreignKey' => 'kit_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'kits_products',
        ]);

        $this->belongsToMany('WorkAreaDetails', [
            'foreignKey' => 'kit_id',
            'targetForeignKey' => 'work_area_detail_id',
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
            ->maxLength('description', 20)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        return $validator;
    }
}
