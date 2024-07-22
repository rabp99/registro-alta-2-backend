<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Colaboradores Model
 *
 * @property \App\Model\Table\EstadosTable&\Cake\ORM\Association\BelongsTo $Estados
 *
 * @method \App\Model\Entity\Colaboradore newEmptyEntity()
 * @method \App\Model\Entity\Colaboradore newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Colaboradore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Colaboradore get($primaryKey, $options = [])
 * @method \App\Model\Entity\Colaboradore findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Colaboradore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Colaboradore[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Colaboradore|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Colaboradore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Colaboradore[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Colaboradore[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Colaboradore[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Colaboradore[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ColaboradoresTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setEntityClass('Colaborador');
        $this->setTable('colaboradores');
        $this->setDisplayField('nro_documento');
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
            ->maxLength('trabajador', 150)
            ->requirePresence('trabajador', 'create')
            ->notEmptyString('trabajador');

        $validator
            ->scalar('grupo_ocupacional')
            ->maxLength('grupo_ocupacional', 60)
            ->allowEmptyString('grupo_ocupacional');

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
