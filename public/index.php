<?php
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory as Request;

chdir(dirname(__DIR__));
require_once "vendor/autoload.php";

### Initialization
$request = Request::fromGlobals();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse('Hello, ' . $name . ' '))
    ->withHeader('X-Developer', 'Alex');

header('HTTP/1.0 ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
foreach ($response->getHeaders() as $key => $value) {
    header($key . ':' . implode(', ', $value));
}

echo $response->getBody();
