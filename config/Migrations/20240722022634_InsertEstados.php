<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class InsertEstados extends AbstractMigration
{

    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('estados');

        $table->insert(['descripcion' => 'Activo'])->saveData();
        $table->insert(['descripcion' => 'Inactivo'])->saveData();
        $table->insert(['descripcion' => 'Solicitado'])->saveData();
        $table->insert(['descripcion' => 'Entregado'])->saveData();
        $table->insert(['descripcion' => 'Entrada'])->saveData();
        $table->insert(['descripcion' => 'Salida'])->saveData();
        $table->insert(['descripcion' => 'Disponible'])->saveData();
        $table->insert(['descripcion' => 'Ocupada'])->saveData();
        $table->insert(['descripcion' => 'Devuelto'])->saveData();
        $table->insert(['descripcion' => 'Break Inicio'])->saveData();
        $table->insert(['descripcion' => 'Break Fin'])->saveData();
        $table->insert(['descripcion' => 'En Vestidores'])->saveData();
        $table->insert(['descripcion' => 'En Lavandería'])->saveData();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM estados');
    }
}
