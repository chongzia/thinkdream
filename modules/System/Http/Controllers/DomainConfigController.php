<?php

namespace Modules\System\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Modules\System\Models\SystemConfig as Config;
use Modules\System\Support\Configure;

class DomainConfigController extends Controller
{
    public function index()
    {
        return \config('domain');
    }

    public function store(Request $request, Config $configModel)
    {
        $type = $request->get('type');

        return $configModel->storeBy(Configure::parse("domain.$type", $request->except('type')));
    }

}
