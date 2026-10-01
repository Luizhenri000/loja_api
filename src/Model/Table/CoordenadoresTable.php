<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CoordenadoresTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('coordenadores');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Usuarios', [
            'className' => 'Users',
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Cursos', ['foreignKey' => 'curso_id', 'joinType' => 'INNER']);
        $this->hasMany('Disponibilidades', ['foreignKey' => 'coordenador_id']);
        $this->hasMany('Agendamentos', ['foreignKey' => 'coordenador_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->integer('usuario_id')->requirePresence('usuario_id', 'create')->notEmptyString('usuario_id');
        $validator->integer('curso_id')->requirePresence('curso_id', 'create')->notEmptyString('curso_id');
        $validator->dateTime('deleted')->allowEmptyDateTime('deleted');
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['usuario_id']), ['errorField' => 'usuario_id']);
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'), ['errorField' => 'usuario_id']);
        $rules->add($rules->existsIn(['curso_id'], 'Cursos'), ['errorField' => 'curso_id']);
        return $rules;
    }
}
