<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Supervisores seed.
 */
class SupervisoresSeed extends AbstractSeed
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
                'tipo_documento' => 'DNI',
                'nro_documento' => '42913787',
                'trabajador' => utf8_decode('CARDENAS VARGAS, BETSY'),
                'estado_id' => 1
            ], [
                'tipo_documento' => 'DNI',
                'nro_documento' => '46385785',
                'trabajador' => utf8_decode('CHIGNE CARRERA, JHANINA'),
                'estado_id' => 1
            ], [
                'tipo_documento' => 'DNI',
                'nro_documento' => '41836210',
                'trabajador' => utf8_decode('HUARIPATA, CARDENAS, JOSE WILSON'),
                'estado_id' => 1
            ], [
                'tipo_documento' => 'DNI',
                'nro_documento' => '45265506',
                'trabajador' => utf8_decode('LEDEZMA TRUJILLO, GIOVANNA'),
                'estado_id' => 1
            ], [
                'tipo_documento' => 'DNI',
                'nro_documento' => '22301514',
                'trabajador' => utf8_decode('MOREANO AROSTE, GLORIA'),
                'estado_id' => 1
            ], [
                'tipo_documento' => 'DNI',
                'nro_documento' => '44077548',
                'trabajador' => utf8_decode('RIVERA CHICLOTE, ERIKA'),
                'estado_id' => 1
            ], [
                'tipo_documento' => 'DNI',
                'nro_documento' => '42576672',
                'trabajador' => utf8_decode('TORRES QUEVEDO, CRISTHIAN'),
                'estado_id' => 1
            ], [
                'tipo_documento' => 'DNI',
                'nro_documento' => '43554560',
                'trabajador' => utf8_decode('VALDEZ ESPINOZA, ROSA'),
                'estado_id' => 1
            ], [
                'tipo_documento' => 'DNI',
                'nro_documento' => '19693397',
                'trabajador' => utf8_decode('VEJARANO GASTAÑADUI, JULIA'),
                'estado_id' => 1
            ], [
                'tipo_documento' => 'DNI',
                'nro_documento' => '44290001',
                'trabajador' => utf8_decode('VARGAS RODRIGUEZ, FANNY'),
                'estado_id' => 1
            ]
        ];
        
        $table = $this->table('supervisores');
        $table->insert($data)->save();
    }
}
