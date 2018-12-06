<?php
use Zend\Diactoros\Response\HtmlResponse;
use Framework\Http\ResponseSender as RSender;
use Zend\Diactoros\ServerRequestFactory as Request;

//chdir(dirname(__DIR__));
require_once '../vendor/autoload.php';

### Initialization
$request = Request::fromGlobals();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse('Hello, ' . $name . '!'))->withHeader('X-Developer', 'Alex');
RSender::send($response);
