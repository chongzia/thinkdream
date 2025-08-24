<?php

namespace Modules\System\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Modules\System\Support\Routes;

class RouteController extends Controller
{
    public function index(Routes $route, Request $request)
    {
        return $route->all($request->all());
    }

    public function cache()
    {
        return Artisan::call('route:cache');
    }
}
