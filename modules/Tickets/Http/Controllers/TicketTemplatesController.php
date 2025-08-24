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
        // 验证模板是否存在
        $template = $this->model->firstBy($id);
        if (!$template) {
            abort(404, '模板不存在');
        }

        // 更新表单配置
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
        // 验证模板是否存在
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

    /**
     * 获取启用状态的模板列表（用于工单创建）
     *
     * @param  Request  $request
     * @return mixed
     */
    public function activeTemplates(Request $request): mixed
    {
        // 构建查询条件
        $query = $this->model->newQuery()
            ->where('ticket_is_active', 1) // 只获取启用的模板
            ->orderBy('created_at', 'desc');

        // 搜索条件
        if ($request->filled('ticket_name')) {
            $query->where('ticket_name', 'like', '%' . $request->input('ticket_name') . '%');
        }

        // 分页参数
        $page = max(1, (int) $request->input('page', 1));
        $limit = min(50, max(1, (int) $request->input('limit', 10))); // 限制每页最大50条

        // 执行分页查询
        $total = $query->count();
        $data = $query->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get([
                'id',
                'ticket_name',
                'ticket_description',
                'ticket_accept',
                'ticket_process',
                'ticket_accept_days',
                'ticket_process_days',
                'ticket_is_active',
                'created_at',
                'updated_at'
            ]);

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($total / $limit)
        ];
    }
}
