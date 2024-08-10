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
 * @property \App\Model\Table\EstadosTable&\Cake\ORM\Association\BelongsTo $GruposOcupacionales
 *
 * @method \App\Model\Entity\Colaborador newEmptyEntity()
 * @method \App\Model\Entity\Colaborador newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Colaborador[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Colaborador get($primaryKey, $options = [])
 * @method \App\Model\Entity\Colaborador findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Colaborador patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Colaborador[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Colaborador|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Colaborador saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Colaborador[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Colaborador[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Colaborador[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Colaborador[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ColaboradoresTable extends Table
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

        $this->setEntityClass('Colaborador');
        $this->setTable('colaboradores');
        $this->setDisplayField('nombre_completo');
        $this->setPrimaryKey('dni_medico');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('GruposOcupacionales', [
            'foreignKey' => 'grupo_ocupacional_id',
            'joinType' => 'INNER',
        ])->setProperty("grupo_ocupacional");

        $this->hasMany('Programaciones', [
            'foreignKey' => 'dni_medico'
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
            ->add('dni_medico', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'El DNI del médico ya existe.'
            ]);

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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['estado_id'], 'Estados'), ['errorField' => 'estado_id']);

        return $rules;
    }
}
