<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AlterUsersAgendamento extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('users');

        $table->addColumn('tipo_usuario', 'string', [
            'default' => 'responsavel',
            'limit' => 20,
            'null' => false,
            'after' => 'password',
        ]);

        $table->addColumn('telefone', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true,
            'after' => 'tipo_usuario',
        ]);

        $table->update();
    }
}
