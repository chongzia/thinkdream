<?php

declare(strict_types=1);

namespace Modules\System\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Catch\Facade\Admin;
use Illuminate\Support\Facades\DB;
use Modules\System\Models\PersonalAccessTokens;
use Modules\User\Models\User;

class PersonalAccessTokensController extends Controller
{
    public function __construct(
        protected readonly PersonalAccessTokens $model
    ) {}

    public function index(): mixed
    {
        return $this->model->setBeforeGetList(function ($query) {
            return $query->addSelect([
                'username' => User::whereColumn('id', $this->model->getTable().'.tokenable_id')
                    ->select(DB::raw('username')),
            ])
                ->join('log_login', 'log_login.token_id', $this->model->getTable().'.id')
                ->addSelect('log_login.login_ip', 'log_login.location');
        })->getList();
    }

    /**
     * @return mixed
     */
    public function destroy($id)
    {
        if ($this->model->deletesBy($id)) {
            Admin::clearUserPersonalToken($id);

        }

        return true;
    }
}
