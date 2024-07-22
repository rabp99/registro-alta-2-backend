<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GruposOcupacionales Model
 *
 * @method \App\Model\Entity\GruposOcupacionale newEmptyEntity()
 * @method \App\Model\Entity\GruposOcupacionale newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\GruposOcupacionale[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GruposOcupacionale get($primaryKey, $options = [])
 * @method \App\Model\Entity\GruposOcupacionale findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\GruposOcupacionale patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GruposOcupacionale[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GruposOcupacionale|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GruposOcupacionale saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GruposOcupacionale[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GruposOcupacionale[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\GruposOcupacionale[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\GruposOcupacionale[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class GruposOcupacionalesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('grupos_ocupacionales');
        $this->setDisplayField('descripcion');
        $this->setPrimaryKey('id');
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
            ->scalar('descripcion')
            ->maxLength('descripcion', 60)
            ->requirePresence('descripcion', 'create')
            ->notEmptyString('descripcion');

        $validator
            ->scalar('flag_show')
            ->maxLength('flag_show', 45)
            ->allowEmptyString('flag_show');

        return $validator;
    }
}
