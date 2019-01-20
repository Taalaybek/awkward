<?php
use App\Http\Action;
use App\Http\Middleware;
use Aura\Router\RouterContainer;
use Framework\Http\MiddleResolver;
use Framework\Pipeline\Pipeline;
use Zend\Diactoros\ServerRequestFactory;
use Framework\Http\Router\AuraAdapterRouter;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\Exception\RequestNotMatchedException;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

### Initialization

$aura = new RouterContainer();
$routes = $aura->getMap();
### Action

$params = [
  'users' => ['admin' => 'pass']
];

$routes->get('home', '/', Action\HelloAction::class);
$routes->get( 'about', '/about', Action\AboutAction::class);

$routes->get('blog', '/blog', Action\Blog\IndexAction::class);
$routes->get('blog_show', '/blog/{id}', Action\Blog\BlogShowAction::class)->tokens(['id' => '\d+']);

$routes->get('cabinet', '/cabinet', [
  Middleware\ProfilerMiddleware::class,
  new Middleware\BasicAuthMiddleware($params['users']),
  Action\CabinetAction::class
]);

$router = new AuraAdapterRouter($aura);
$request = ServerRequestFactory::fromGlobals();

$resolver = new MiddleResolver();

try {
  $result = $router->match($request);
  
  foreach ($result->getAttributes() as $attribute => $value) {
    $request = $request->withAttribute($attribute, $value);
  }
  
  $handlers = $result->getHandler();
  $pipeline = new Pipeline();
  
  foreach (is_array($handlers) ? $handlers : [$handlers] as $handler) {
    $pipeline->pipe($resolver->resolve($handler));
  }
  $response = $pipeline($request, new Middleware\NotFoundHandler());
  
} catch (RequestNotMatchedException $e) {
  $handler = new Middleware\NotFoundHandler();
  $response = $handler($request);
}

### Postprocessing

$response = $response->withHeader('X-Developer', 'Alex');

### Sending
$send = new SapiEmitter();
$send->emit($response);
