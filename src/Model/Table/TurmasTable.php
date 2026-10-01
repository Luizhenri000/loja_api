<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TurmasTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('turmas');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Cursos', ['foreignKey' => 'curso_id', 'joinType' => 'INNER']);
        $this->hasMany('Alunos', ['foreignKey' => 'turma_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->scalar('nome')->maxLength('nome', 100)->requirePresence('nome', 'create')->notEmptyString('nome');
        $validator->integer('curso_id')->requirePresence('curso_id', 'create')->notEmptyString('curso_id');
        $validator->scalar('turno')->maxLength('turno', 20)->requirePresence('turno', 'create')->notEmptyString('turno');
        $validator->integer('ano')->requirePresence('ano', 'create')->notEmptyString('ano');
        $validator->dateTime('deleted')->allowEmptyDateTime('deleted');
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['curso_id'], 'Cursos'), ['errorField' => 'curso_id']);
        return $rules;
    }
}
