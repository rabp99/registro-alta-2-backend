<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reutilizables Model
 *
 * @property \App\Model\Table\TiposTable&\Cake\ORM\Association\BelongsTo $Tipos
 * @property \App\Model\Table\EstadosTable&\Cake\ORM\Association\BelongsTo $Estados
 * @property \App\Model\Table\ReutilizablesSolicitudesDetallesTable&\Cake\ORM\Association\HasMany $ReutilizablesSolicitudesDetallesTable
 *
 * @method \App\Model\Entity\Reutilizable newEmptyEntity()
 * @method \App\Model\Entity\Reutilizable newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Reutilizable[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reutilizable get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reutilizable findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Reutilizable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reutilizable[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reutilizable|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reutilizable saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reutilizable[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Reutilizable[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Reutilizable[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Reutilizable[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ReutilizablesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('reutilizables');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id']);

        $this->belongsTo('Tipos', [
            'foreignKey' => 'tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ReutilizablesSolicitudesDetalles')
            ->setForeignKey('reutilizable_id');
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
            ->integer('codigo')
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

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
        $rules->add($rules->existsIn(['tipo_id'], 'Tipos'), ['errorField' => 'tipo_id']);
        $rules->add($rules->existsIn(['estado_id'], 'Estados'), ['errorField' => 'estado_id']);

        return $rules;
    }
}
