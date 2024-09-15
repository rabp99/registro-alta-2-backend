<?php

declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;

class DatabaseSeedCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        // Antes de eso ejecutar en consola bin\cake bake migration_snapshot Initiral
        // exec('bin\cake migrations rollback');
        // exec('bin\cake migrations migrate');
        exec('bin\cake migrations seed --seed UsersSeed');

        $io->out("Seed Completed!");
    }
}
