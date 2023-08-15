<?php


use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Application\Controllers\ChatSocket;
require 'C:\laragon\www\chatSystem/vendor/autoload.php';
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatSocket()
        )
    ),
    8080
);

$server->run();