<?php

declare(strict_types=1);

namespace Modules\Tickets\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Tickets\Http\Requests\TicketTemplateRequest;

use Modules\Tickets\Models\TicketTemplates;

/**
 * @class TicketTemplatesController
 */
class TicketTemplatesController extends Controller
{
    /**
     * @param  TicketTemplates  $model
     */
    public function __construct(
        protected readonly TicketTemplates $model,
    ) {}

    /**
     * 列表
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->model->getList();
    }

    /**
     * 保存数据
     *
     * @param  TicketTemplateRequest  $request
     * @return mixed
     */
    public function store(TicketTemplateRequest $request): mixed
    {
        return $this->model->storeBy($request->validated());
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
     * @param  TicketTemplateRequest  $request
     * @return mixed
     */
    public function update(mixed $id, TicketTemplateRequest $request): mixed
    {
        return $this->model->updateBy($id, $request->validated());
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

    /**
     * 保存模板表单配置
     *
     * @param  mixed  $id
     * @param  TicketTemplateRequest  $request
     * @return mixed
     */
    public function saveForm(mixed $id, TicketTemplateRequest $request): mixed
    {
        $template = $this->model->firstBy($id);
        if (!$template) {
            abort(404, '模板不存在');
        }

        return $this->model->updateBy($id, $request->validated());
    }

    /**
     * 获取模板表单配置
     *
     * @param  mixed  $id
     * @return mixed
     */
    public function getForm(mixed $id): mixed
    {
        $template = $this->model->firstBy($id);
        if (!$template) {
            abort(404, '模板不存在');
        }

        return [
            'id' => $template->id,
            'ticket_name' => $template->ticket_name,
            'ticket_form' => $template->ticket_form ?? '',
        ];
    }


}
