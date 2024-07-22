<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Consumibles seed.
 */
class ConsumiblesSeed extends AbstractSeed
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
                'descripcion' => utf8_decode("ELASTO MÉDICAS"),
                'stock' => 100,
                'marca' => 'HONEYWELL',
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("ELASTO MÉDICAS"),
                'stock' => 100,
                'marca' => '3M',
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("N95"),
                'stock' => 100,
                'marca' => null,
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("LENTES ACRÍLICOS"),
                'stock' => 100,
                'marca' => null,
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("LENTES HERMÉTICOS"),
                'stock' => 100,
                'marca' => null,
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("FILTROS"),
                'stock' => 100,
                'marca' => 'HONEYWELL',
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("FILTROS"),
                'stock' => 100,
                'marca' => '3M',
                'estado_id' => 1,
            ]
        ];
        
        $table = $this->table('consumibles');
        $table->insert($data)->save();
    }
}