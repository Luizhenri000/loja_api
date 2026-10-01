<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateCoordenadores extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('coordenadores');
        $table->addColumn('usuario_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('curso_id', 'integer', ['null' => false, 'signed' => false]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->addColumn('deleted', 'datetime', ['null' => true, 'default' => null]);
        $table->addIndex(['usuario_id'], ['unique' => true]);
        $table->addForeignKey('usuario_id', 'users', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE']);
        $table->addForeignKey('curso_id', 'cursos', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE']);
        $table->create();
    }
}
