<?php
$name = $_GET['name'] ?: 'Alex';

header('X-Developer: Alex');
echo "Hello, " . $name;