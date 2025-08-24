<?php
namespace Modules\Pay\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Modules\System\Models\SystemConfig;
use Modules\System\Support\Configure;

class ConfigController extends Controller
{
    public function show($driver)
    {
        return config("pay.{$driver}");
    }

    public function store(Request $request, SystemConfig $config)
    {
        return $config->storeBy(Configure::parse('pay', $request->all()));
    }
}
