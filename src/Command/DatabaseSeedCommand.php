<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;

class DatabaseSeedCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io) {
        // Antes de eso ejecutar en consola bin\cake bake migration_snapshot Initiral
        // exec('bin\cake migrations rollback');
        // exec('bin\cake migrations migrate');
        exec('bin\cake migrations seed --seed EstadosSeed');
        exec('bin\cake migrations seed --seed UsersSeed');
        exec('bin\cake migrations seed --seed TiposSeed');
        exec('bin\cake migrations seed --seed ReutilizablesSeed');
        exec('bin\cake migrations seed --seed GruposSeed');
        exec('bin\cake migrations seed --seed PreguntasSeed');
        exec('bin\cake migrations seed --seed ColaboradoresSeed');
        exec('bin\cake migrations seed --seed ConsumiblesSeed');
        exec('bin\cake migrations seed --seed SupervisoresSeed');
        exec('bin\cake migrations seed --seed GruposOcupacionalesSeed');
        
        /*
        exec('bin\cake migrations seed --seed AreasSeed');
        exec('bin\cake migrations seed --seed TrabajadoresSeed');
        exec('bin\cake migrations seed --seed EntradasSeed');
        exec('bin\cake migrations seed --seed SalidasSeed');
        */
        
        $io->out("¡Seed Completo!");
    }
}