<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cidades Model
 *
 * @property \App\Model\Table\EstadosTable&\Cake\ORM\Association\BelongsTo $Estados
 *
 * @method \App\Model\Entity\Cidade newEmptyEntity()
 * @method \App\Model\Entity\Cidade newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Cidade[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cidade get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cidade findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Cidade patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cidade[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cidade|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cidade saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cidade[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cidade[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cidade[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cidade[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CidadesTable extends Table
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

        $this->setTable('cidades');
        $this->setDisplayField('name');
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
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name');

        $validator
            ->scalar('uf')
            ->maxLength('uf', 2)
            ->allowEmptyString('uf');

        $validator
            ->integer('cod_municipio')
            ->allowEmptyString('cod_municipio');

        $validator
            ->integer('estado_id')
            ->notEmptyString('estado_id');

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
        $rules->add($rules->existsIn('estado_id', 'Estados'), ['errorField' => 'estado_id']);

        return $rules;
    }
}
