<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Estados seed.
 */
class EstadosSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'descripcion' => utf8_decode("Activo"),
            ], [
                'descripcion' => utf8_decode("Inactivo"),
            ], [
                'descripcion' => utf8_decode("Solicitado"),
            ], [
                'descripcion' => utf8_decode("Entregado"),
            ], [
                'descripcion' => utf8_decode("Entrada"),
            ], [
                'descripcion' => utf8_decode("Salida"),
            ], [
                'descripcion' => utf8_decode("Disponible"),
            ], [
                'descripcion' => utf8_decode("Ocupada"),
            ], [
                'descripcion' => utf8_decode("Devuelto"),
            ], [
                'descripcion' => utf8_decode("Break Inicio"),
            ], [
                'descripcion' => utf8_decode("Break Fin"),
            ], [
                'descripcion' => utf8_decode("En Vestidores"),
            ], [
                'descripcion' => utf8_decode("En Lavandería"),
            ]
        ];
        
        $table = $this->table('estados');
        $table->insert($data)->save();
    }
}
