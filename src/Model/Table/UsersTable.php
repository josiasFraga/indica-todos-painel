<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ServiceProvidersTable&\Cake\ORM\Association\BelongsTo $ServiceProviders
 * @property \App\Model\Table\ChangePasswordTokensTable&\Cake\ORM\Association\HasMany $ChangePasswordTokens
 * @property \App\Model\Table\CreditCardsTable&\Cake\ORM\Association\HasMany $CreditCards
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 * @property \App\Model\Table\ServiceProviderVisitsTable&\Cake\ORM\Association\HasMany $ServiceProviderVisits
 * @property \App\Model\Table\UserLocationsTable&\Cake\ORM\Association\HasMany $UserLocations
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ServiceProviders', [
            'foreignKey' => 'service_provider_id',
        ]);
        $this->hasMany('ChangePasswordTokens', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('CreditCards', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('ServiceProviderVisits', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('UserLocations', [
            'foreignKey' => 'user_id',
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
            ->integer('service_provider_id')
            ->allowEmptyString('service_provider_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 14)
            ->allowEmptyString('cpf');

            $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create') // Exige a presença apenas na criação
            ->notEmptyString('password', null, 'create') // Exige que não esteja vazia apenas na criação
            ->allowEmptyString('password', 'update'); // Permite estar vazia na atualização

        $validator
            ->scalar('phone')
            ->maxLength('phone', 255)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 255)
            ->notEmptyString('photo');

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->existsIn('service_provider_id', 'ServiceProviders'), ['errorField' => 'service_provider_id']);

        return $rules;
    }
}
