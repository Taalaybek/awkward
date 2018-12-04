<?php
use Framework\Http\Request;

chdir(dirname(__DIR__));
require_once "src/Framework/http/Request.php";

### Initialization

$request = new Request();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';

header('X-Developer: Alex');
echo "Hello, " . $name;