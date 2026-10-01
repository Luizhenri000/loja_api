<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Agendamento extends Entity
{
    protected array $_accessible = [
        'responsavel_id' => true,
        'aluno_id' => true,
        'coordenador_id' => true,
        'data' => true,
        'hora_inicio' => true,
        'hora_fim' => true,
        'motivo' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'responsavel' => true,
        'aluno' => true,
        'coordenador' => true,
    ];
}
