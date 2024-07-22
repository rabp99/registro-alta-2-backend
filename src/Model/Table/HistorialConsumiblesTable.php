<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HistorialConsumibles Model
 *
 * @property \App\Model\Table\ConsumiblesTable&\Cake\ORM\Association\BelongsTo $Consumibles
 * @property \App\Model\Table\EntregasTable&\Cake\ORM\Association\BelongsTo $Entregas
 *
 * @method \App\Model\Entity\HistorialConsumible newEmptyEntity()
 * @method \App\Model\Entity\HistorialConsumible newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\HistorialConsumible[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HistorialConsumible get($primaryKey, $options = [])
 * @method \App\Model\Entity\HistorialConsumible findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\HistorialConsumible patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HistorialConsumible[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\HistorialConsumible|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HistorialConsumible saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HistorialConsumible[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HistorialConsumible[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\HistorialConsumible[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HistorialConsumible[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class HistorialConsumiblesTable extends Table
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

        $this->setTable('historial_consumibles');
        $this->setDisplayField('fecha_hora');
        $this->setPrimaryKey('id');

        $this->belongsTo('Consumibles', [
            'foreignKey' => 'consumible_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Entregas', [
            'foreignKey' => 'entrega_id',
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
            ->scalar('tipo')
            ->maxLength('tipo', 10)
            ->allowEmptyString('tipo');

        $validator
            ->dateTime('fecha_hora')
            ->requirePresence('fecha_hora', 'create')
            ->notEmptyDateTime('fecha_hora');

        $validator
            ->integer('cantidad')
            ->allowEmptyString('cantidad');

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
        $rules->add($rules->existsIn(['consumible_id'], 'Consumibles'), ['errorField' => 'consumible_id']);
        $rules->add($rules->existsIn(['entrega_id'], 'Entregas'), ['errorField' => 'entrega_id']);

        return $rules;
    }
}
