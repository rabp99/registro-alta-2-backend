<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use League\Csv\Reader;

/**
 * Colaboradores seed.
 */
class ColaboradoresSeed extends AbstractSeed
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
        
        // load the CSV document from a stream
        $csv = Reader::createFromPath('config/tables/colaboradores.csv', 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
       
        foreach ($csv as $record) {
            $data[] = [
                'tipo_documento' => utf8_decode($record["tipo_documento"]) ?? null,
                'nro_documento' => utf8_decode($record["nro_documento"]) ?? null,
                'trabajador' => utf8_decode($record["trabajador"]) ?? null,
                'grupo_ocupacional' => utf8_decode($record["grupo_ocupacional"]) ?? null,
                'estado_id' => $record["estado_id"]
            ];
        }
        
        $table = $this->table('colaboradores');
        $table->insert($data)->save();
    }
}
