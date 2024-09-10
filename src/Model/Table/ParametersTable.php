<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\FrozenDate;

/**
 * Parameters Model
 *
 * @method \App\Model\Entity\Parameter newEmptyEntity()
 * @method \App\Model\Entity\Parameter newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Parameter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Parameter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Parameter findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Parameter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Parameter[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Parameter|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Parameter saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Parameter[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Parameter[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Parameter[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Parameter[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ParametersTable extends Table
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

        $this->setTable('parameters');
        $this->setDisplayField('value');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('UserTrackable');
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
            ->scalar('key')
            ->maxLength('key', 100)
            ->requirePresence('key', 'create')
            ->notEmptyString('key')
            ->add('key', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('value')
            ->maxLength('value', 500)
            ->allowEmptyString('value');

        $validator
            ->boolean('visible')
            ->allowEmptyString('visible');

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
        $rules->add($rules->isUnique(['key']), ['errorField' => 'key']);

        return $rules;
    }

    public function getNextReportProductRequestsRecordNunber($userId)
    {
        $parameter = $this->find()
            ->where(["Parameters.key" => 'reports.product_requests_records.record_number'])
            ->first();

        $nextReportProductRequestsRecordNunber = "";

        $now = FrozenDate::now();
        $newDateFormat = $now->format("Ym");

        if ($parameter->value) {
            $currentDateFormat = substr($parameter->value, 0, 6);
            if ($currentDateFormat === $newDateFormat) {
                $numberPart = substr($parameter->value, 7);
                $newNumber = str_pad(strval((int)$numberPart + 1), 3, '0', STR_PAD_LEFT);
                $nextReportProductRequestsRecordNunber = $newDateFormat . "-" . $newNumber;
            } else {
                $nextReportProductRequestsRecordNunber = $newDateFormat . "-001";
            }
        } else {
            $nextReportProductRequestsRecordNunber = $newDateFormat . "-001";
        }

        $parameter->value = $nextReportProductRequestsRecordNunber;
        $this->saveOrFail($parameter, ['userId' => $userId]);

        return $nextReportProductRequestsRecordNunber;
    }
}
