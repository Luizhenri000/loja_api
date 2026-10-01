<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CursosTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('cursos');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->hasMany('Turmas', ['foreignKey' => 'curso_id']);
        $this->hasMany('Coordenadores', ['foreignKey' => 'curso_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->scalar('nome')->maxLength('nome', 150)->requirePresence('nome', 'create')->notEmptyString('nome');
        $validator->scalar('sigla')->maxLength('sigla', 20)->requirePresence('sigla', 'create')->notEmptyString('sigla');
        $validator->dateTime('deleted')->allowEmptyDateTime('deleted');
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['sigla']), ['errorField' => 'sigla']);
        return $rules;
    }
}
