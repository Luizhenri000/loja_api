<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateTurmas extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('turmas');
        $table->addColumn('nome', 'string', ['limit' => 100, 'null' => false]);
        $table->addColumn('curso_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('turno', 'string', ['limit' => 20, 'null' => false]);
        $table->addColumn('ano', 'integer', ['limit' => 4, 'null' => false]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->addColumn('deleted', 'datetime', ['null' => true, 'default' => null]);
        $table->addForeignKey('curso_id', 'cursos', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE']);
        $table->create();
    }
}
