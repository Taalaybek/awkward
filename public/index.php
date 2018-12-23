<?php
use App\Http\Action;
use App\Http\Middleware;
use Aura\Router\RouterContainer;
use Framework\Http\ActionResolver;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\HtmlResponse;
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

$routes->get('cabinet', '/cabinet', function(ServerRequestInterface $request) use ($params){
  $auth = new Middleware\BasicAuthMiddleware($params['users']);
  $cabinet = new Action\CabinetAction();
  
  return $auth($request, function (ServerRequestInterface $request) use ($cabinet) {
    return $cabinet($request);
  });
});

$router = new AuraAdapterRouter($aura);
$request = ServerRequestFactory::fromGlobals();

$resolver = new ActionResolver();

try {
  $result = $router->match($request);
  
  foreach ($result->getAttributes() as $attribute => $value) {
    $request = $request->withAttribute($attribute, $value);
  }
  
  $handler = $result->getHandler();
  $action = $resolver->handler($handler);
  $response = $action($request);
} catch (RequestNotMatchedException $e) {
  $response = new HtmlResponse('Undefined page', 404);
}

### Postprocessing

$response = $response->withHeader('X-Developer', 'Alex');

### Sending
$send = new SapiEmitter();
$send->emit($response);
