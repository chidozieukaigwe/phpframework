<?php declare(strict_types=1);

use ChidoUkaigwe\Framework\Http\Kernel;
use ChidoUkaigwe\Framework\Http\Request;
use ChidoUkaigwe\Framework\Http\Response;

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__) . '/vendor/autoload.php';

//  Request Recieved 
$request = Request::createFromGlobals();

//  Perform some logic
$kernel = new Kernel();

//  send response (string of content)
$response = $kernel->handle($request);

$response->send();