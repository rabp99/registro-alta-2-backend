<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Trabajadores seed.
 */
class TrabajadoresSeed extends AbstractSeed
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
                'estado_id' => 1,
                'dni' => 70801887,
                'nombres' => utf8_decode("ROBERTO ANDRË"),
                'apellido_paterno' => utf8_decode("BOCANEGRA"),
                'apellido_materno' => utf8_decode("PALACIOS"),
            ], [
                'estado_id' => 1,
                'dni' => 17915884,
                'nombres' => utf8_decode("DONATILA DEL ROSARIO"),
                'apellido_paterno' => utf8_decode("PALACIOS"),
                'apellido_materno' => utf8_decode("SÁNCHEZ"),
            ]
        ];
        
        $table = $this->table('trabajadores');
        $table->insert($data)->save();
    }
}
