<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlunosTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('alunos');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Turmas', ['foreignKey' => 'turma_id', 'joinType' => 'INNER']);
        $this->belongsTo('Responsaveis', [
            'className' => 'Users',
            'foreignKey' => 'responsavel_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Agendamentos', ['foreignKey' => 'aluno_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->scalar('nome')->maxLength('nome', 150)->requirePresence('nome', 'create')->notEmptyString('nome');
        $validator->scalar('matricula')->maxLength('matricula', 50)->requirePresence('matricula', 'create')->notEmptyString('matricula');
        $validator->integer('turma_id')->requirePresence('turma_id', 'create')->notEmptyString('turma_id');
        $validator->integer('responsavel_id')->requirePresence('responsavel_id', 'create')->notEmptyString('responsavel_id');
        $validator->dateTime('deleted')->allowEmptyDateTime('deleted');
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['matricula']), ['errorField' => 'matricula']);
        $rules->add($rules->existsIn(['turma_id'], 'Turmas'), ['errorField' => 'turma_id']);
        $rules->add($rules->existsIn(['responsavel_id'], 'Responsaveis'), ['errorField' => 'responsavel_id']);
        return $rules;
    }
}
