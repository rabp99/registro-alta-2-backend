<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Log\Log;

class EntradaCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io) {
        $programacionesTable = TableRegistry::getTableLocator()->get('programaciones');
        $threeHoursLater = new FrozenTime('3 hours ago');
        
        $result = $programacionesTable->updateAll([
            'fecha_hora_entrada' => date('Y-m-d H:i:s'),
            'estado_id' => 5,
            'flag_entrada_sistema' => '1'
        ], [
            "CONCAT(fecha_programacion, ' ', hor_inicio) <=" => $threeHoursLater->format('Y-m-d H:i'),
            "estado_id" => 4
        ]);
        if ($result) {
            Log::notice(date('Y-m-d H:i:s'), 'cron');
            $io->out("¡Se registraron las entradas correctamente!");
        } else {
            $io->out("¡No se pudo registrar las entradas!");
        }
    }
}