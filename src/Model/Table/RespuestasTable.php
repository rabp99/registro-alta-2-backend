<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Respuestas Model
 *
 * @property \App\Model\Table\CuestionariosTable&\Cake\ORM\Association\BelongsTo $Cuestionarios
 * @property \App\Model\Table\PreguntasTable&\Cake\ORM\Association\BelongsTo $Preguntas
 *
 * @method \App\Model\Entity\Respuesta newEmptyEntity()
 * @method \App\Model\Entity\Respuesta newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Respuesta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Respuesta get($primaryKey, $options = [])
 * @method \App\Model\Entity\Respuesta findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Respuesta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Respuesta[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Respuesta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Respuesta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Respuesta[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Respuesta[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Respuesta[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Respuesta[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RespuestasTable extends Table
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

        $this->setTable('respuestas');
        $this->setDisplayField('valor');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cuestionarios', [
            'foreignKey' => 'cuestionario_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Preguntas', [
            'foreignKey' => 'pregunta_id',
            'joinType' => 'INNER',
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
            ->scalar('valor')
            ->maxLength('valor', 1)
            ->allowEmptyString('valor');

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
        $rules->add($rules->existsIn(['cuestionario_id'], 'Cuestionarios'), ['errorField' => 'cuestionario_id']);
        $rules->add($rules->existsIn(['pregunta_id'], 'Preguntas'), ['errorField' => 'pregunta_id']);

        return $rules;
    }
}
