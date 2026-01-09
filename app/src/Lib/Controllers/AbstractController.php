<?php

namespace App\Lib\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;

abstract class AbstractController {
    public abstract function process(Request $request): Response;
}
