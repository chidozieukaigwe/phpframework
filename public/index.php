<?php declare(strict_types=1);

use ChidoUkaigwe\Framework\Http\Kernel;
use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;
use ChidoUkaigwe\Framework\Routing\Router;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$container = require BASE_PATH . '/config/services.php';

//  Request Recieved 
$request = Request::createFromGlobals();

//  Perform some logic
$kernel = $container->get(Kernel::class);

//  send response (string of content)
$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);