<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateCursos extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('cursos');
        $table->addColumn('nome', 'string', ['limit' => 150, 'null' => false]);
        $table->addColumn('sigla', 'string', ['limit' => 20, 'null' => false]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->addColumn('deleted', 'datetime', ['null' => true, 'default' => null]);
        $table->addIndex(['sigla'], ['unique' => true]);
        $table->create();
    }
}
