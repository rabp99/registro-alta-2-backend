<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Entregas Model
 *
 * @property \App\Model\Table\ConsumiblesTable&\Cake\ORM\Association\BelongsTo $Consumibles
 * @property \App\Model\Table\HistorialConsumiblesTable&\Cake\ORM\Association\HasMany $HistorialConsumibles
 *
 * @method \App\Model\Entity\Entrega newEmptyEntity()
 * @method \App\Model\Entity\Entrega newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Entrega[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Entrega get($primaryKey, $options = [])
 * @method \App\Model\Entity\Entrega findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Entrega patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Entrega[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Entrega|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Entrega saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Entrega[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Entrega[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Entrega[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Entrega[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EntregasTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('entregas');
        $this->setDisplayField('fecha');
        $this->setPrimaryKey('id');

        $this->belongsTo('Consumibles', [
            'foreignKey' => 'consumible_id',
            'joinType' => 'INNER',
        ]);
        
        $this->hasMany('HistorialConsumibles')
            ->setForeignKey('entrega_id');
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
            ->date('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmptyDate('fecha');

        $validator
            ->integer('cantidad')
            ->allowEmptyString('cantidad');

        $validator
            ->scalar('tipo_documento')
            ->maxLength('tipo_documento', 10)
            ->requirePresence('tipo_documento', 'create')
            ->notEmptyString('tipo_documento');

        $validator
            ->scalar('nro_documento')
            ->maxLength('nro_documento', 9)
            ->requirePresence('nro_documento', 'create')
            ->notEmptyString('nro_documento');

        $validator
            ->scalar('profesional')
            ->maxLength('profesional', 90)
            ->requirePresence('profesional', 'create')
            ->notEmptyString('profesional');

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

        return $rules;
    }
}
