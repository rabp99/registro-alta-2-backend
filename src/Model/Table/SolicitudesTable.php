<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Solicitudes Model
 *
 * @property \App\Model\Table\ProgramacionesTable&\Cake\ORM\Association\BelongsTo $Programaciones
 * @property \App\Model\Table\EstadosTable&\Cake\ORM\Association\BelongsTo $Estados
 *
 * @method \App\Model\Entity\Solicitud newEmptyEntity()
 * @method \App\Model\Entity\Solicitud newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Solicitud[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Solicitud get($primaryKey, $options = [])
 * @method \App\Model\Entity\Solicitud findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Solicitud patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Solicitud[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Solicitud|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Solicitud saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Solicitud[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Solicitud[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Solicitud[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Solicitud[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SolicitudesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('solicitudes');
        $this->setEntityClass('Solicitud');
        $this->setDisplayField('fecha_solicitud');
        $this->setPrimaryKey('id');

        $this->belongsTo('Programaciones', [
            'foreignKey' => ['programacion_centro', 'programacion_dni_medico', 'programacion_fecha_programacion', 'programacion_turno'],
        ])->setProperty('programacion');
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ReutilizablesSolicitudesDetalles')
            ->setForeignKey('solicitud_id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_entrega_id',
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
            ->scalar('programaciones_centro')
            ->maxLength('programaciones_centro', 10)
            ->allowEmptyString('programaciones_centro');

        $validator
            ->date('programaciones_fecha_programacion')
            ->allowEmptyDate('programaciones_fecha_programacion');

        $validator
            ->scalar('programaciones_turno')
            ->maxLength('programaciones_turno', 15)
            ->allowEmptyString('programaciones_turno');

        $validator
            ->scalar('area_ingreso')
            ->maxLength('area_ingreso', 60)
            ->requirePresence('area_ingreso', 'create')
            ->notEmptyString('area_ingreso');

        $validator
            ->scalar('tipo_epp')
            ->maxLength('tipo_epp', 10)
            ->requirePresence('tipo_epp', 'create')
            ->notEmptyString('tipo_epp');

        $validator
            ->integer('cantidad')
            ->requirePresence('cantidad', 'create')
            ->notEmptyString('cantidad');

        $validator
            ->dateTime('fecha_solicitud')
            ->requirePresence('fecha_solicitud', 'create')
            ->notEmptyDateTime('fecha_solicitud');

        $validator
            ->dateTime('fecha_entrega')
            ->allowEmptyDateTime('fecha_entrega');

        $validator
            ->scalar('firma')
            ->allowEmptyString('firma');

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
