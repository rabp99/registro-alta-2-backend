<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Areas seed.
 */
class TiposSeed extends AbstractSeed
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
                'descripcion' => utf8_decode("CHAQUETA"),
                'flag_salida' => 0,
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("PANTALÓN"),
                'flag_salida' => 0,
                'estado_id' => 1,
            ], [
                'descripcion' => utf8_decode("MANDIL"),
                'flag_salida' => 1,
                'estado_id' => 1,
            ]
        ];
        
        $table = $this->table('tipos');
        $table->insert($data)->save();
    }
}
