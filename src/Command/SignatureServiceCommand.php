<?php

declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Services\SignatureService;

class SignatureServiceCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SignatureService()
                )
            ),
            8766
        );

        $server->run();
    }
}
