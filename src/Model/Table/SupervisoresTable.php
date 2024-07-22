<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Supervisores Model
 *
 * @property \App\Model\Table\EstadosTable&\Cake\ORM\Association\BelongsTo $Estados
 *
 * @method \App\Model\Entity\Supervisore newEmptyEntity()
 * @method \App\Model\Entity\Supervisore newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Supervisore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Supervisore get($primaryKey, $options = [])
 * @method \App\Model\Entity\Supervisore findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Supervisore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Supervisore[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Supervisore|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Supervisore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Supervisore[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Supervisore[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Supervisore[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Supervisore[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SupervisoresTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('supervisores');
        $this->setEntityClass('Supervisor');
        $this->setDisplayField('trabajador');
        $this->setPrimaryKey('id');

        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

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
            ->scalar('trabajador')
            ->maxLength('trabajador', 120)
            ->requirePresence('trabajador', 'create')
            ->notEmptyString('trabajador');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn(['estado_id'], 'Estados'), ['errorField' => 'estado_id']);

        return $rules;
    }
}
