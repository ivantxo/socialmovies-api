<?php


require __DIR__ . '/vendor/autoload.php';


use React\EventLoop\Factory;
use React\Http\Server;
use \React\Socket\Server as Socket;
use FastRoute\RouteCollector;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteParser\Std;
use Dotenv\Dotenv;
use React\MySQL\Factory as MySQLFactory;


use App\Core\Router;
use App\Core\ErrorHandler;
use App\Core\JsonRequestDecoder;
use App\Authentication\Storage as AuthModel;
use App\Authentication\Authenticator;
use App\Authentication\SignUpController;
use App\Authentication\SignInController;
use App\Authentication\GetAuthenticatedUser;
use App\Likes\Storage as Likes;
use App\Likes\Controller\Like;
use App\Likes\Controller\UnLike;
use App\Movies\LinkMovie;
use App\Notifications\CreateNotification;
use App\Notifications\DeleteNotification;
use App\Notifications\GetAllNotifications;
use App\Notifications\GetNotificationsByUserId;
use App\Notifications\MarkNotificationsRead;
use App\Posts\Storage as Posts;
use App\Posts\Controller\CreatePost;
use App\Posts\Controller\DeletePost;
use App\Posts\Controller\GetAllPosts;
use App\Posts\Controller\GetPostById;
use App\Users\Storage as Users;
use App\Users\Controller\AddUserDetails;
use App\Users\Controller\GetUserDetails;

$loop = Factory::create();

$env = Dotenv::createImmutable(__DIR__);
$env->load();
$mysql = new MySQLFactory($loop);
$uri = $_ENV['DB_USER']
    . ':' . $_ENV['DB_PASS']
    . '@' . $_ENV['DB_HOST']
    . '/' . $_ENV['DB_NAME'];
$connection = $mysql->createLazyConnection($uri);
$posts = new Posts($connection);
$authModel = new AuthModel($connection);
$authenticator = new Authenticator($authModel, $_ENV['JWT_KEY']);
$likes = new Likes($connection);
$users = new Users($connection);

$routes = new RouteCollector(new Std(), new GroupCountBased());

// authentication routes
$routes->post('/auth/signup', new SignUpController($authModel));
$routes->post('/auth/signin', new SignInController($authenticator));
$routes->get('/user', new GetAuthenticatedUser());

// likes routes
$routes->get('/post/{id:\d+}/like', new Like($likes));
$routes->get('/post/{id:\d+}/unlike', new UnLike($likes));

// movies routes
$routes->post('linkmovie/{id:\d+}', new LinkMovie());

// notifications routes
$routes->post('/notifications', new CreateNotification());
$routes->delete('/notifications/{id:\d+}', new DeleteNotification());
$routes->get('/notifications', new GetAllNotifications());
$routes->get('/notifications/{id:\d+}', new GetNotificationsByUserId());
$routes->post('/notificationsread', new MarkNotificationsRead());

// posts routes
$routes->post('/posts', new CreatePost($posts));
$routes->delete('/posts/{id:\d+}', new DeletePost($posts));
$routes->get('/posts', new GetAllPosts($posts));
$routes->get('/posts/{id:\d+}', new GetPostById($posts));

// users routes
$routes->post('/users', new AddUserDetails());
$routes->get('/users/{id:\d+}', new GetUserDetails($users));


$server = new Server(
    $loop,
    new ErrorHandler(),
    new JsonRequestDecoder(),
    new Router($routes)
);

$socket = new Socket('0.0.0.0:8000', $loop);
$server->listen($socket);

echo 'Listening on '
    . str_replace('tcp', 'http', $socket->getAddress())
    . PHP_EOL;

$loop->run();
