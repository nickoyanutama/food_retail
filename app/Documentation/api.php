<?php
require_once __DIR__ . ("/../../vendor/autoload.php");

$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'] . '\app\Controller']);
header('Content-Type: application/x-JSON');
echo $openapi->toJSON();
