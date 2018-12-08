<?php
use App\Http\Action;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\HtmlResponse;
use Framework\Http\Router\RouteCollection;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\Exception\RequestNotMatchedException;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

### Initialization

$routes = new RouteCollection();

### Action

$routes->get('home', '/', Action\HelloAction::class);

$routes->get( 'about', '/about', Action\AboutAction::class);

$routes->get('blog', '/blog', Action\Blog\IndexAction::class);

$routes->get('blog_show', '/blog/{id}', Action\Blog\BlogShowAction::class, ['id' => '\d+']);

$router = new \Framework\Http\Router\Router($routes);
$request = ServerRequestFactory::fromGlobals();

try {
  $result = $router->match($request);
  
  foreach ($result->getAttributes() as $attribute => $value) {
    $request = $request->withAttribute($attribute, $value);
  }
  
  $handler = $result->getHandler();
  $action = is_string($handler) ? new $handler(): $handler;
  $response = $action($request);
} catch (RequestNotMatchedException $e) {
  $response = new HtmlResponse('Undefined page', 404);
}

### Postprocessing

$response = $response->withHeader('X-Developer', 'Alex');

### Sending
$send = new SapiEmitter();
$send->emit($response);
