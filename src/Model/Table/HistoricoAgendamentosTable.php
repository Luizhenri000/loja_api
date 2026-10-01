<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class HistoricoAgendamentosTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('historico_agendamentos');
        $this->setPrimaryKey('id');

        $this->belongsTo('Agendamentos', ['foreignKey' => 'agendamento_id', 'joinType' => 'INNER']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->integer('agendamento_id')->requirePresence('agendamento_id', 'create')->notEmptyString('agendamento_id');
        $validator->scalar('acao')->maxLength('acao', 30)->requirePresence('acao', 'create')->notEmptyString('acao');
        $validator->date('data_anterior')->allowEmptyDate('data_anterior');
        $validator->time('hora_anterior')->allowEmptyTime('hora_anterior');
        $validator->date('data_nova')->allowEmptyDate('data_nova');
        $validator->time('hora_nova')->allowEmptyTime('hora_nova');
        $validator->scalar('observacao')->allowEmptyString('observacao');
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['agendamento_id'], 'Agendamentos'), ['errorField' => 'agendamento_id']);
        return $rules;
    }
}
