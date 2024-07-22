<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Faker\Factory;

/**
 * Salidas seed.
 */
class SalidasSeed extends AbstractSeed
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
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $data[] = [
                'trabajador_id' => $faker->numberBetween(1, 2),
                'user_id' => $faker->numberBetween(1, 2),
                'estado_id' => 1,
                'fecha_hora' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d h:i'),
            ];
        }
        
        $table = $this->table('salidas');
        $table->insert($data)->save();
    }
}
