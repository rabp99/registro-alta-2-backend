<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cuestionarios Model
 *
 * @method \App\Model\Entity\Cuestionario newEmptyEntity()
 * @method \App\Model\Entity\Cuestionario newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Cuestionario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cuestionario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cuestionario findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Cuestionario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cuestionario[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cuestionario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cuestionario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cuestionario[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cuestionario[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cuestionario[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cuestionario[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CuestionariosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('cuestionarios');
        $this->setDisplayField('fecha_hora');
        $this->setPrimaryKey(['id']);
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
            ->scalar('programacion_centro')
            ->maxLength('programacion_centro', 10)
            ->allowEmptyString('programacion_centro', null, 'create');

        $validator
            ->scalar('programacion_dni_medico')
            ->maxLength('programacion_dni_medico', 9)
            ->allowEmptyString('programacion_dni_medico', null, 'create');

        $validator
            ->date('programacion_fecha_programacion')
            ->allowEmptyDate('programacion_fecha_programacion', null, 'create');

        $validator
            ->scalar('programacion_turno')
            ->maxLength('programacion_turno', 15)
            ->allowEmptyString('programacion_turno', null, 'create');

        $validator
            ->dateTime('fecha_hora')
            ->requirePresence('fecha_hora', 'create')
            ->notEmptyDateTime('fecha_hora');

        $validator
            ->scalar('supervisor_dni')
            ->maxLength('supervisor_dni', 9)
            ->requirePresence('supervisor_dni', 'create')
            ->notEmptyString('supervisor_dni');

        $validator
            ->scalar('supervisor_nombres')
            ->maxLength('supervisor_nombres', 150)
            ->requirePresence('supervisor_nombres', 'create')
            ->notEmptyString('supervisor_nombres');

        return $validator;
    }
}
