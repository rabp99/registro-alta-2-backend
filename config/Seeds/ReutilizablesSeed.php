<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Estados seed.
 */
class ReutilizablesSeed extends AbstractSeed
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
        $data = [];
        // Tipo 1 -> Chaqueta // 1538
        for ($i = 0; $i < 2038; $i++) {
            $data[] = [
                'tipo_id' => 1,
                'estado_id' => 7,
                'codigo' => $i + 1,
            ];
        }
        // Tipo 2 -> PANTALÓN // 1610
        for ($i = 0; $i < 2110; $i++) {
            $data[] = [
                'tipo_id' => 2,
                'estado_id' => 7,
                'codigo' => $i + 1,
            ];
        }
        // Tipo 3 -> MANDILES // 1680
        for ($i = 0; $i < 2180; $i++) {
            $data[] = [
                'tipo_id' => 3,
                'estado_id' => 7,
                'codigo' => $i + 1,
            ];
        }
        $table = $this->table('reutilizables');
        $table->insert($data)->save();
    }
}
