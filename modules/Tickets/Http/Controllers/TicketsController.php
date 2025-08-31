<?php

declare(strict_types=1);

namespace Modules\Tickets\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Tickets\Models\Tickets;
use Modules\Tickets\Models\TicketReplies;
use Modules\Tickets\Models\TicketTemplates;

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
     * 展示数据（增强版，包含关联数据）
     *
     * @param  mixed  $id
     * @return array
     */
    public function show(mixed $id): array
    {
        // 获取工单基本信息
        $ticket = $this->model->with(['ticketTemplates'])->firstBy($id);
        
        if (!$ticket) {
            return [];
        }
        
        // 返回工单详情，包含模板信息
        return [
            'ticket' => $ticket,
            'template' => $ticket->ticketTemplates,
        ];
    }

    /**
     * 获取工单回复列表
     *
     * @param  mixed  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReplies(mixed $id)
    {
        return TicketReplies::where('ticket_id', $id)
                          ->with('user:id,username')
                          ->orderBy('created_at', 'asc')
                          ->get();
    }

    /**
     * 添加工单回复
     *
     * @param  mixed  $id
     * @param  Request  $request
     * @return mixed
     */
    public function addReply(mixed $id, Request $request): mixed
    {
        $data = $request->validate([
            'ticket_accept_status' => 'required|integer|in:1,2,3,4',
            'ticket_content' => 'required|string|max:1000',
        ]);
        
        $data['ticket_id'] = $id;
        $data['ticket_user_id'] = $this->getLoginUser()->id;
        
        // 创建回复
        $reply = TicketReplies::create($data);
        
        // 根据回复类型更新工单状态
        $this->updateTicketStatus($id, $data['ticket_accept_status']);
        
        return $reply->load('user:id,username');
    }

    /**
     * 根据回复类型更新工单状态
     *
     * @param  mixed  $ticketId
     * @param  int  $replyStatus
     * @return void
     */
    private function updateTicketStatus(mixed $ticketId, int $replyStatus): void
    {
        $statusMap = [
            1 => 1, // 用户回复 -> 待处理
            2 => 2, // 受理回复 -> 已受理
            3 => 4, // 处理回复 -> 处理中
            4 => 6, // 关闭回复 -> 已完成
        ];
        
        if (isset($statusMap[$replyStatus])) {
            $updateData = ['ticket_status' => $statusMap[$replyStatus]];
            
            // 如果是关闭回复，设置关闭时间
            if ($replyStatus === 4) {
                $updateData['closed_at'] = time();
            }
            
            // 如果是受理回复，设置受理时间和受理人
            if ($replyStatus === 2) {
                $updateData['ticket_accept_at'] = time();
                $updateData['ticket_node_accept'] = $this->getLoginUser()->id;
            }
            
            // 如果是处理回复，设置处理时间
            if ($replyStatus === 3) {
                $updateData['ticket_process_at'] = time();
            }
            
            $this->model->updateBy($ticketId, $updateData);
        }
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
