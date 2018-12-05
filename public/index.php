<?php
chdir(dirname(__DIR__));
require_once "./vendor/autoload.php";

use Framework\Http\Request;

### Initialization

$request = new Request($_GET, $_POST);

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';

header('X-Developer: Alex');
echo "Hello, " . $name;