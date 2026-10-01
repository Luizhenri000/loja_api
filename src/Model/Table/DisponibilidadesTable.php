<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class DisponibilidadesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('disponibilidades');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Coordenadores', ['foreignKey' => 'coordenador_id', 'joinType' => 'INNER']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->integer('coordenador_id')->requirePresence('coordenador_id', 'create')->notEmptyString('coordenador_id');
        $validator->date('data')->requirePresence('data', 'create')->notEmptyDate('data');
        $validator->time('hora_inicio')->requirePresence('hora_inicio', 'create')->notEmptyTime('hora_inicio');
        $validator->time('hora_fim')->requirePresence('hora_fim', 'create')->notEmptyTime('hora_fim');
        $validator->boolean('disponivel')->notEmptyString('disponivel');
        $validator->dateTime('deleted')->allowEmptyDateTime('deleted');
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['coordenador_id'], 'Coordenadores'), ['errorField' => 'coordenador_id']);
        return $rules;
    }
}
