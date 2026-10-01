<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateAgendamentos extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('agendamentos');
        $table->addColumn('responsavel_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('aluno_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('coordenador_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('data', 'date', ['null' => false]);
        $table->addColumn('hora_inicio', 'time', ['null' => false]);
        $table->addColumn('hora_fim', 'time', ['null' => false]);
        $table->addColumn('motivo', 'text', ['null' => false]);
        $table->addColumn('status', 'string', ['limit' => 30, 'default' => 'agendada', 'null' => false]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->addColumn('deleted', 'datetime', ['null' => true, 'default' => null]);
        $table->addIndex(['coordenador_id', 'data', 'hora_inicio'], ['unique' => true]);
        $table->addForeignKey('responsavel_id', 'users', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE']);
        $table->addForeignKey('aluno_id', 'alunos', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE']);
        $table->addForeignKey('coordenador_id', 'coordenadores', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE']);
        $table->create();
    }
}
