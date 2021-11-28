<?php

// server.php

 use Ratchet\Server\IoServer;
 use Ratchet\Http\HttpServer;
 use Ratchet\WebSocket\WsServer;
 use MyApp\Chat;

    require dirname(__DIR__) . '/vendor/autoload.php';

    // $server = IoServer::factory(
    //     new HttpServer(
    //         new WsServer(
    //             new Chat()
    //         )
    //     ),
    //    5000
    // );

    // $server->run(); 

$chatServer = new Chat();
$port = 5000;
$ip='0.0.0.0';

$wsServer = new WsServer($chatServer);
// $wsServer->disableVersion(0); // old, bad, protocol version
        
$http = new HttpServer($wsServer);
$server = IoServer::factory($http, $port, $ip);

$server->run();

?>