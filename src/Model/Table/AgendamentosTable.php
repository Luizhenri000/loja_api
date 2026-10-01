<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class AgendamentosTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('agendamentos');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Responsaveis', [
            'className' => 'Users',
            'foreignKey' => 'responsavel_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Alunos', ['foreignKey' => 'aluno_id', 'joinType' => 'INNER']);
        $this->belongsTo('Coordenadores', ['foreignKey' => 'coordenador_id', 'joinType' => 'INNER']);
        $this->hasMany('HistoricoAgendamentos', ['foreignKey' => 'agendamento_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->integer('responsavel_id')->requirePresence('responsavel_id', 'create')->notEmptyString('responsavel_id');
        $validator->integer('aluno_id')->requirePresence('aluno_id', 'create')->notEmptyString('aluno_id');
        $validator->integer('coordenador_id')->requirePresence('coordenador_id', 'create')->notEmptyString('coordenador_id');
        $validator->date('data')->requirePresence('data', 'create')->notEmptyDate('data');
        $validator->time('hora_inicio')->requirePresence('hora_inicio', 'create')->notEmptyTime('hora_inicio');
        $validator->time('hora_fim')->requirePresence('hora_fim', 'create')->notEmptyTime('hora_fim');
        $validator->scalar('motivo')->requirePresence('motivo', 'create')->notEmptyString('motivo');
        $validator->scalar('status')->maxLength('status', 30)->notEmptyString('status');
        $validator->dateTime('deleted')->allowEmptyDateTime('deleted');
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['responsavel_id'], 'Responsaveis'), ['errorField' => 'responsavel_id']);
        $rules->add($rules->existsIn(['aluno_id'], 'Alunos'), ['errorField' => 'aluno_id']);
        $rules->add($rules->existsIn(['coordenador_id'], 'Coordenadores'), ['errorField' => 'coordenador_id']);
        return $rules;
    }
}
