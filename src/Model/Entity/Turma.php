<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Turma extends Entity
{
    protected array $_accessible = [
        'nome' => true,
        'curso_id' => true,
        'turno' => true,
        'ano' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'curso' => true,
    ];
}
