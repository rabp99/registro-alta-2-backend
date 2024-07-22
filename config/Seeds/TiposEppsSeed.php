<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Tipos seed.
 */
class TiposEppsSeed extends AbstractSeed
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
                'descripcion' => utf8_decode("EPP 0"),
                'area_id' => 1,
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("EPP 1"),
                'area_id' => 1,
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("EPP 2"),
                'area_id' => 1,
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("EPP 5"),
                'area_id' => 1,
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("EPP 8"),
                'area_id' => 1,
                'estado_id' => 1,
            ]
        ];
        
        $table = $this->table('tipos_epps');
        $table->insert($data)->save();
    }
}
