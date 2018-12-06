<?php
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory as Request;

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

### Initialization

$request = Request::fromGlobals();

### Action

$path = $request->getUri()->getPath();
$action = null;

if ($path === '/') {
  $action = function (ServerRequestInterface $request){
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    return new HtmlResponse('Hello, ' . $name . '!');
  };
} elseif ($path === '/about') {
  $action = function() {
      return new HtmlResponse('I am a simple page');
  };
} elseif ($path === '/blog') {
  $action = function(){
    return new JsonResponse([
      ['id'=>1, 'title'=>'first', 'body'=>'some text'],
      ['id'=>2, 'title'=>'second', 'body'=>'some text two'],
    ]);
  };
} elseif (preg_match('#/blog/(?P<id>\d+)$#i', $path, $matches)) {
  $request = $request->withAttribute('id', $matches['id']);
  
  $action = function(ServerRequestInterface $request) {
    $id = $request->getAttribute('id');
    if ($id > 2) {
      return new JsonResponse(['error'=>'Undefined page'], 404);
    }
    return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
  };
}
if ($action){
  $response = $action($request);
} else {
  return new JsonResponse(['error'=>'Undefined page'], 404);
}

### Postprocessing

$response = $response->withHeader('X-Developer', 'Alex');

### Sending
$send = new SapiEmitter();
$send->emit($response);
