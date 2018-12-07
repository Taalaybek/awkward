<?php
use Framework\Http\Router\RegexRoute;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Framework\Http\Router\RouteCollection;
use Psr\Http\Message\ServerRequestInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\Exception\RequestNotMatchedException;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

### Initialization

$routes = new RouteCollection();

### Action

$routes->get(
  'home',
  '/',
  function (ServerRequestInterface $request) {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    return new HtmlResponse('Hello, ' . $name . '!');
  }
);

$routes->get(
  'about',
  '/about',
  function () {
    return new HtmlResponse('I am Simple site');
  }
);

$routes->get(
  'blog',
  '/blog',
  function () {
    return new JsonResponse([
      ['id' => 1, 'title' => 'lorem ipsum', 'body' => 'some content'],
      ['id' => 2, 'title' => 'heredoc nowdoc', 'body' => 'lady milien paco rabban']
    ]);
  }
);

$routes->get(
  'blog_show',
  '/blog/{id}',
  function (ServerRequestInterface $request) {
    $id = $request->getAttribute('id');
    if ($id > 2) {
      return new HtmlResponse('Undefined page', 404);
    }
    return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
  },
  ['id' => '\d+']
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
