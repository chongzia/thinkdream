<?php

namespace Modules\Wechat\Http\Controllers;

use Catch\Base\CatchController;
use Modules\Wechat\Support\Official\OfficialAccount;

class OfficialAccountController extends CatchController
{
    public function sign(OfficialAccount $officialAccount)
    {
        return $officialAccount->serve();
    }
}
