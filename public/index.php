<?php
use App\Http\Action\HelloAction;
use App\Http\Action\AboutAction;
use App\Http\Action\Blog\IndexAction;
use Zend\Diactoros\ServerRequestFactory;
use App\Http\Action\Blog\BlogShowAction;
use Zend\Diactoros\Response\HtmlResponse;
use Framework\Http\Router\RouteCollection;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\Exception\RequestNotMatchedException;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

### Initialization

$routes = new RouteCollection();

### Action

$routes->get('home', '/', new HelloAction());

$routes->get( 'about', '/about', new AboutAction());

$routes->get('blog', '/blog', new IndexAction());

$routes->get('blog_show', '/blog/{id}', new BlogShowAction(), ['id' => '\d+']
);

$router = new \Framework\Http\Router\Router($routes);
$request = ServerRequestFactory::fromGlobals();

try {
  $result = $router->match($request);
  
  foreach ($result->getAttributes() as $attribute => $value) {
    $request = $request->withAttribute($attribute, $value);
  }
  
  $action = $result->getHandler();
  $response = $action($request);
} catch (RequestNotMatchedException $e) {
  $response = new HtmlResponse('Undefined page', 404);
}

### Postprocessing

$response = $response->withHeader('X-Developer', 'Alex');

### Sending
$send = new SapiEmitter();
$send->emit($response);
