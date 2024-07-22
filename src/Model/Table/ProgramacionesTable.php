<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Programaciones Model
 *
 * @method \App\Model\Entity\Programacione newEmptyEntity()
 * @method \App\Model\Entity\Programacione newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Programacione[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Programacione get($primaryKey, $options = [])
 * @method \App\Model\Entity\Programacione findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Programacione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Programacione[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Programacione|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Programacione saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Programacione[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Programacione[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Programacione[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Programacione[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProgramacionesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('programaciones');
        $this->setDisplayField('centro');
        $this->setPrimaryKey(['centro', 'dni_medico', 'fecha_programacion', 'turno']);
        $this->setEntityClass('Programacion');
        
        $this->belongsTo('Estados')
            ->setForeignKey('estado_id')
            ->setJoinType('INNER');
        
        $this->hasMany('Solicitudes')
            ->setForeignKey(['programacion_centro', 'programacion_dni_medico', 'programacion_fecha_programacion', 'programacion_turno']);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
            ->scalar('centro')
            ->maxLength('centro', 10)
            ->allowEmptyString('centro', null, 'create');

        $validator
            ->scalar('periodo')
            ->maxLength('periodo', 10)
            ->requirePresence('periodo', 'create')
            ->notEmptyString('periodo');

        $validator
            ->scalar('area')
            ->maxLength('area', 90)
            ->requirePresence('area', 'create')
            ->notEmptyString('area');

        $validator
            ->scalar('servicio')
            ->maxLength('servicio', 120)
            ->requirePresence('servicio', 'create')
            ->notEmptyString('servicio');

        $validator
            ->scalar('actividad')
            ->maxLength('actividad', 120)
            ->requirePresence('actividad', 'create')
            ->notEmptyString('actividad');

        $validator
            ->scalar('subactividad')
            ->maxLength('subactividad', 120)
            ->requirePresence('subactividad', 'create')
            ->notEmptyString('subactividad');

        $validator
            ->scalar('consultorio')
            ->maxLength('consultorio', 90)
            ->allowEmptyString('consultorio');

        $validator
            ->scalar('ubicacionconsult')
            ->maxLength('ubicacionconsult', 60)
            ->allowEmptyString('ubicacionconsult');

        $validator
            ->scalar('dni_medico')
            ->maxLength('dni_medico', 9)
            ->allowEmptyString('dni_medico', null, 'create');

        $validator
            ->scalar('profesional')
            ->maxLength('profesional', 160)
            ->allowEmptyString('profesional');

        $validator
            ->scalar('grupo_ocupacional')
            ->maxLength('grupo_ocupacional', 90)
            ->allowEmptyString('grupo_ocupacional');

        $validator
            ->scalar('tip_programacion')
            ->maxLength('tip_programacion', 10)
            ->allowEmptyString('tip_programacion');

        $validator
            ->date('fecha_programacion')
            ->allowEmptyDate('fecha_programacion', null, 'create');

        $validator
            ->scalar('hor_inicio')
            ->maxLength('hor_inicio', 5)
            ->allowEmptyString('hor_inicio');

        $validator
            ->scalar('hor_fin')
            ->maxLength('hor_fin', 5)
            ->allowEmptyString('hor_fin');

        $validator
            ->scalar('estado_programacion')
            ->maxLength('estado_programacion', 15)
            ->allowEmptyString('estado_programacion');

        $validator
            ->scalar('motivo_suspension')
            ->maxLength('motivo_suspension', 30)
            ->allowEmptyString('motivo_suspension');

        $validator
            ->scalar('cod_planilla')
            ->maxLength('cod_planilla', 10)
            ->allowEmptyString('cod_planilla');

        $validator
            ->scalar('turno')
            ->maxLength('turno', 15)
            ->allowEmptyString('turno', null, 'create');

        $validator
            ->scalar('condtrabajador')
            ->maxLength('condtrabajador', 60)
            ->allowEmptyString('condtrabajador');

        $validator
            ->scalar('pertenece_otro_cas')
            ->maxLength('pertenece_otro_cas', 2)
            ->allowEmptyString('pertenece_otro_cas');

        $validator
            ->scalar('area_ingreso')
            ->maxLength('area_ingreso', 60)
            ->allowEmptyString('area_ingreso');

        $validator
            ->scalar('tipo_epp')
            ->maxLength('tipo_epp', 10)
            ->allowEmptyString('tipo_epp');

        $validator
            ->integer('cantidad')
            ->allowEmptyString('cantidad');

        $validator
            ->date('fecha_entrega')
            ->allowEmptyDateTime('fecha_entrega', null, 'create');

        $validator
            ->scalar('firma')
            ->allowEmptyString('firma');

        return $validator;
    }
}
