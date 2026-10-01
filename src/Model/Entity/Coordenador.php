<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Coordenador extends Entity
{
    protected array $_accessible = [
        'usuario_id' => true,
        'curso_id' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'usuario' => true,
        'curso' => true,
    ];
}
