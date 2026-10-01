<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class HistoricoAgendamento extends Entity
{
    protected array $_accessible = [
        'agendamento_id' => true,
        'acao' => true,
        'data_anterior' => true,
        'hora_anterior' => true,
        'data_nova' => true,
        'hora_nova' => true,
        'observacao' => true,
        'created' => true,
        'agendamento' => true,
    ];
}
