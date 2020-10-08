<?php


require __DIR__ . '/vendor/autoload.php';


use React\EventLoop\Factory;
use React\Http\Server;
use \React\Socket\Server as Socket;
use FastRoute\RouteCollector;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteParser\Std;


use App\Core\Router;
use App\Authentication\SignUpController;


$loop = Factory::create();

$routes = new RouteCollector(new Std(), new GroupCountBased());

$routes->post('/auth/signup', new SignUpController());

$server = new Server(
    $loop,
    new Router($routes)
);

$socket = new Socket('0.0.0.0:8000', $loop);
$server->listen($socket);

echo 'Listening on '
    . str_replace('tcp', 'http', $socket->getAddress())
    . PHP_EOL;

$loop->run();
