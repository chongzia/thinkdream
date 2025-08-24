<?php

declare(strict_types=1);

namespace Modules\System\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Modules\System\Models\SystemConfig;
use Modules\System\Support\Configure;

class WechatConfigController extends Controller
{
    public function __construct(
        protected readonly SystemConfig $model
    ) {
    }

    public function store(Request $request)
    {
        $driver = $request->get('driver');
        $config = Configure::parse("wechat.$driver", $request->except('driver'));

        return $this->model->storeBy($config);
    }

    public function show($driver = null)
    {
        return config("wechat.$driver");
    }
}
