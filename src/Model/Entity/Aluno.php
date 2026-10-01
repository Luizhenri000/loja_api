<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Aluno extends Entity
{
    protected array $_accessible = [
        'nome' => true,
        'matricula' => true,
        'turma_id' => true,
        'responsavel_id' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'turma' => true,
        'responsavel' => true,
    ];
}
