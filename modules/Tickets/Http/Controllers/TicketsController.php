<?php

declare(strict_types=1);

namespace Modules\Tickets\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Tickets\Models\Tickets;

/**
 * @class TicketsController
 */
class TicketsController extends Controller
{
    /**
     * @param  Tickets  $model
     */
    public function __construct(
        protected readonly Tickets $model,
    ) {}

    /**
     * 列表
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->model->setBeforeGetList(function ($query) {
            // 应用数据权限：根据用户角色配置的数据权限范围过滤工单
            return $query->dataRange($this->getLoginUser()->roles);
        })->getList();
    }

    /**
     * 保存数据
     *
     * @param  Request  $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->model->storeBy($request->all());
    }

    /**
     * 展示数据
     *
     * @param  mixed  $id
     * @return Model|null
     */
    public function show(mixed $id): ?Model
    {
        return $this->model->firstBy($id, columns: $this->model->getForm());
    }

    /**
     * 更新数据
     *
     * @param  mixed  $id
     * @param  Request  $request
     * @return mixed
     */
    public function update(mixed $id, Request $request): mixed
    {
        return $this->model->updateBy($id, $request->all());
    }

    /**
     * 删除数据
     *
     * @param  mixed  $id
     * @return bool|null
     */
    public function destroy(mixed $id): ?bool
    {
        return $this->model->deleteBy($id);
    }
}
