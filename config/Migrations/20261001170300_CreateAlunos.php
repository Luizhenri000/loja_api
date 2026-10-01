<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateAlunos extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('alunos');
        $table->addColumn('nome', 'string', ['limit' => 150, 'null' => false]);
        $table->addColumn('matricula', 'string', ['limit' => 50, 'null' => false]);
        $table->addColumn('turma_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('responsavel_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->addColumn('deleted', 'datetime', ['null' => true, 'default' => null]);
        $table->addIndex(['matricula'], ['unique' => true]);
        $table->addForeignKey('turma_id', 'turmas', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE']);
        $table->addForeignKey('responsavel_id', 'users', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE']);
        $table->create();
    }
}
