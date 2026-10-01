<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->hasMany('Alunos', [
            'foreignKey' => 'responsavel_id',
            'className' => 'Alunos',
        ]);

        $this->hasOne('Coordenadores', [
            'foreignKey' => 'usuario_id',
            'className' => 'Coordenadores',
        ]);

        $this->hasMany('Agendamentos', [
            'foreignKey' => 'responsavel_id',
            'className' => 'Agendamentos',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('nome')
            ->maxLength('nome', 180)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 11)
            ->requirePresence('cpf', 'create')
            ->notEmptyString('cpf');

        $validator
            ->date('dtNasc')
            ->requirePresence('dtNasc', 'create')
            ->notEmptyDate('dtNasc');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('tipo_usuario')
            ->maxLength('tipo_usuario', 20)
            ->requirePresence('tipo_usuario', 'create')
            ->notEmptyString('tipo_usuario')
            ->inList('tipo_usuario', ['responsavel', 'coordenador']);

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 20)
            ->allowEmptyString('telefone');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->isUnique(['cpf']), ['errorField' => 'cpf']);

        return $rules;
    }
}
