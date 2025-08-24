<?php

namespace Modules\Wechat\Http\Controllers;

use Catch\Base\CatchController;
use Illuminate\Http\Request;
use Modules\Wechat\Support\Official\OfficialMenu;

class OfficialMenuController extends CatchController
{
    public function __construct(protected OfficialMenu $menu)
    {
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
        $this->menu->create($request->all());
    }
}
