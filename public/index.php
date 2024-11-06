<?php declare(strict_types=1);

use App\EventListener\ContentLengthListener;
use App\EventListener\InternalErrorListener;
use ChidoUkaigwe\Framework\EventDispatcher\EventDispatcher;
use ChidoUkaigwe\Framework\Http\Event\ResponseEvent;
use ChidoUkaigwe\Framework\Http\Kernel;
use ChidoUkaigwe\Framework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$container = require BASE_PATH . '/config/services.php';

//  Bootstrapping
require BASE_PATH. '/bootstrap/bootstrap.php';

//  Request Received 
$request = Request::createFromGlobals();

//  Perform some logic
$kernel = $container->get(Kernel::class);

//  send response (string of content)
$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);