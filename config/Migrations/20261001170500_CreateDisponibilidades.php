<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateDisponibilidades extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('disponibilidades');
        $table->addColumn('coordenador_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('data', 'date', ['null' => false]);
        $table->addColumn('hora_inicio', 'time', ['null' => false]);
        $table->addColumn('hora_fim', 'time', ['null' => false]);
        $table->addColumn('disponivel', 'boolean', ['default' => true, 'null' => false]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->addColumn('deleted', 'datetime', ['null' => true, 'default' => null]);
        $table->addIndex(['coordenador_id', 'data', 'hora_inicio'], ['unique' => true]);
        $table->addForeignKey('coordenador_id', 'coordenadores', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);
        $table->create();
    }
}
