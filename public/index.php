<?php
chdir(dirname(__DIR__));
require_once "./vendor/autoload.php";

use Framework\Http\Response;
use Framework\Http\RequestFactory;

### Initialization

$request = RequestFactory::fromGlobals();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new Response('Hello, ' . $name . ' '))
    ->setHeader('X-Developer', 'Alex');

header('HTTP/1.0 ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
foreach ($response->getHeaders() as $key => $value) {
    header($key . ':' . $value);
}

echo 'Hello, ' . $name;
