<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Disponibilidade extends Entity
{
    protected array $_accessible = [
        'coordenador_id' => true,
        'data' => true,
        'hora_inicio' => true,
        'hora_fim' => true,
        'disponivel' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'coordenador' => true,
    ];
}
