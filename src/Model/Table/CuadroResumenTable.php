<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CuadroResumen Model
 *
 * @property \App\Model\Table\UserEntregasTable&\Cake\ORM\Association\BelongsTo $UserEntregas
 *
 * @method \App\Model\Entity\CuadroResuman newEmptyEntity()
 * @method \App\Model\Entity\CuadroResuman newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CuadroResuman[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CuadroResuman get($primaryKey, $options = [])
 * @method \App\Model\Entity\CuadroResuman findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CuadroResuman patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CuadroResuman[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CuadroResuman|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CuadroResuman saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CuadroResuman[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CuadroResuman[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CuadroResuman[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CuadroResuman[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CuadroResumenTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('cuadro_resumen');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
            ->date('fecha_entrega_date_solicitud')
            ->allowEmptyDate('fecha_entrega_date_solicitud');

        $validator
            ->scalar('nombre_completo')
            ->maxLength('nombre_completo', 120)
            ->requirePresence('nombre_completo', 'create')
            ->notEmptyString('nombre_completo');

        $validator
            ->scalar('username')
            ->maxLength('username', 90)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->decimal('epp_0')
            ->allowEmptyString('epp_0');

        $validator
            ->decimal('epp_2')
            ->allowEmptyString('epp_2');

        $validator
            ->decimal('epp_5')
            ->allowEmptyString('epp_5');

        $validator
            ->decimal('epp_8')
            ->allowEmptyString('epp_8');

        $validator
            ->decimal('respiradores')
            ->allowEmptyString('respiradores');

        $validator
            ->decimal('n95')
            ->allowEmptyString('n95');

        $validator
            ->decimal('lentes')
            ->allowEmptyString('lentes');

        $validator
            ->decimal('filtros')
            ->allowEmptyString('filtros');

        $validator
            ->decimal('mandilones_tela')
            ->allowEmptyString('mandilones_tela');

        $validator
            ->decimal('pantalones_tela')
            ->allowEmptyString('pantalones_tela');

        $validator
            ->decimal('chaquetas_tela')
            ->allowEmptyString('chaquetas_tela');

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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->existsIn(['user_entrega_id'], 'UserEntregas'), ['errorField' => 'user_entrega_id']);

        return $rules;
    }
}
