<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Curso extends Entity
{
    protected array $_accessible = [
        'nome' => true,
        'sigla' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
    ];
}
