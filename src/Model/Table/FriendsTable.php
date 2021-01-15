<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class FriendsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('friends');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'username',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('friend_with')
            ->maxLength('friend_with', 255)
            ->requirePresence('friend_with', 'create')
            ->notEmptyString('friend_with');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        //CHANGEMENT: friend_with 
        $rules->add($rules->isUnique(['username', 'friend_with']), ['errorField' => 'friend_with']);
        $rules->add($rules->existsIn('friend_with', 'Users'));
        return $rules;
    }
}
