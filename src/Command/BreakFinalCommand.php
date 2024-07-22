<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;

class BreakFinalCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io) {
        $programacionesTable = TableRegistry::getTableLocator()->get('programaciones');
        $threeHoursLater = new FrozenTime('3 hours ago');
        
        $result = $programacionesTable->updateAll([
            'fecha_hora_break_final' => date('Y-m-d H:i:s'),
            'estado_id' => 11
        ], [
            "fecha_programacion <=" => $threeHoursLater->format('Y-m-d'),
            "estado_id" => 10
        ]);
        if ($result) {
            $io->out("¡Se registró el break final de todos los trabajadores correctamente!");
        } else {
            $io->out("¡No se pudo registrar el break final de los trabajadores!");
        }
    }
}