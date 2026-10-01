<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class User extends Entity
{
    protected array $_accessible = [
        'nome' => true,
        'cpf' => true,
        'dtNasc' => true,
        'email' => true,
        'password' => true,
        'tipo_usuario' => true,
        'telefone' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'alunos' => true,
        'coordenadore' => true,
        'agendamentos' => true,
    ];

    protected array $_hidden = [
        'password',
    ];
}
