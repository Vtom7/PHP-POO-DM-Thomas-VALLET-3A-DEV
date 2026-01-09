<?php

use App\Lib\Http\Request;
use App\Lib\Http\Router;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    
    $request = new Request();
    $response = Router::route($request);

    echo $response->getContent();
    exit();
} catch(\Exception $e) {
    echo $e->getMessage();
}
