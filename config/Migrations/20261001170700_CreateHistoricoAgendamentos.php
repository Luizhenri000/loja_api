<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateHistoricoAgendamentos extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('historico_agendamentos');
        $table->addColumn('agendamento_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('acao', 'string', ['limit' => 30, 'null' => false]);
        $table->addColumn('data_anterior', 'date', ['null' => true, 'default' => null]);
        $table->addColumn('hora_anterior', 'time', ['null' => true, 'default' => null]);
        $table->addColumn('data_nova', 'date', ['null' => true, 'default' => null]);
        $table->addColumn('hora_nova', 'time', ['null' => true, 'default' => null]);
        $table->addColumn('observacao', 'text', ['null' => true, 'default' => null]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addForeignKey('agendamento_id', 'agendamentos', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->create();
    }
}
