<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Trabajadores seed.
 */
class GruposSeed extends AbstractSeed
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
            [   // grupo_id = 1;
                'descripcion' => utf8_decode('EN ÁREA DE DESINFECCIÓN Y RETIRO DE EPP'),
                'estado_id' => 1
            ], [ // grupo_id = 2;
                'descripcion' => utf8_decode('RETIRO DE MANDILON'),
                'estado_id' => 1
            ], 
            [ // grupo_id = 3;
                'descripcion' => utf8_decode('RETIRO DE MAMELUCO'),
                'estado_id' => 1
            ],
            [ // grupo_id = 4;
                'descripcion' => utf8_decode('CERRADO DE BOLSAS'),
                'estado_id' => 1
            ],[ // grupo_id = 5;
                'descripcion' => utf8_decode('RETIRE EL RESPIRADOR'),
                'estado_id' => 1
            ],
            [ // grupo_id = 6;
                'descripcion' => utf8_decode('LIMPIEZA Y DESINFECCIÓN DE FILTROS'),
                'estado_id' => 1
            ],
            [ // grupo_id = 7;
                'descripcion' => utf8_decode('LIMPIEZA Y DESINFECCIÓN DEL RESPIRADOR ELASTOMÉRICO'),
                'estado_id' => 1
            ]// ...
        ];
        
        $table = $this->table('grupos');
        $table->insert($data)->save();
    }
}
