<?php

declare(strict_types=1);

namespace Modules\Tickets\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Tickets\Models\Tickets;
use Modules\Tickets\Models\TicketTemplates;
use Modules\Tickets\Http\Requests\TicketsAppRequest;
use Modules\Common\Enums\TicketPriority;
use Modules\Common\Repository\Options\Factory;

/**
 * 工单应用控制器 - 用于快速创建工单的应用界面
 * @class TicketsAppController
 */
class TicketsAppController extends Controller
{
    /**
     * @param Tickets $ticketsModel
     * @param TicketTemplates $templatesModel
     */
    public function __construct(
        protected readonly Tickets $ticketsModel,
        protected readonly TicketTemplates $templatesModel,
    ) {}

    /**
     * 获取启用状态的模板列表（用于工单创建应用）
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTemplates(Request $request): mixed
    {
        // 确保只获取启用的模板
        $request->merge(['ticket_is_active' => 1]);
        
        // 使用模型的标准getList方法，这样会保持一致的响应格式
        return $this->templatesModel->getList();
    }

    /**
     * 获取指定模板的表单配置
     *
     * @param mixed $templateId
     * @return JsonResponse
     */
    public function getTemplateForm($templateId): mixed
    {
        // 确保 templateId 是整数
        $templateId = (int) $templateId;
        
        if ($templateId <= 0) {
            throw new \InvalidArgumentException('无效的模板ID');
        }
        
        // 验证模板是否存在且启用
        $template = $this->templatesModel->where('id', $templateId)
            ->where('ticket_is_active', 1)
            ->first();

        if (!$template) {
            throw new \Exception('模板不存在或已禁用');
        }

        return [
            'id' => $template->id,
            'ticket_name' => $template->ticket_name,
            'ticket_form' => $template->ticket_form ?? '',
            'ticket_accept' => $template->ticket_accept,
            'ticket_process' => $template->ticket_process,
            'ticket_accept_days' => $template->ticket_accept_days,
            'ticket_process_days' => $template->ticket_process_days,
        ];
    }

    /**
     * 提交工单
     *
     * @param TicketsAppRequest $request
     * @return JsonResponse
     */
    public function submitTicket(TicketsAppRequest $request): mixed
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();

            // 验证模板是否存在且启用
            $template = $this->templatesModel->where('id', $validated['template_id'])
                ->where('ticket_is_active', 1)
                ->first();

            if (!$template) {
                throw new \Exception('模板不存在或已禁用');
            }

            // 生成工单编号
            $ticketNo = $this->generateTicketNumber();

            // 准备工单数据 (使用数据库实际字段名)
            $ticketData = [
                'ticket_no' => $ticketNo,
                'ticket_name' => $validated['title'],
                'ticket_status' => $validated['status'] ?? 1, // 默认待处理
                'ticket_priority' => $validated['priority'],
                'ticket_template' => $validated['template_id'],
                'ticket_promoter' => auth()->id() ?? 1, // 当前登录用户，默认为1
                'ticket_node_id' => 1, // 默认节点ID，可以根据业务需求调整
                'ticket_node_accept' => $template->ticket_accept,
                'ticket_node_process' => $template->ticket_process,
                'ticket_process_position' => 1, // 初始流程位置为第1个
                'ticket_accept_days' => $template->ticket_accept_days,
                'ticket_process_days' => $template->ticket_process_days,
                'ticket_accept_overdue' => 0, // 默认未超期
                'ticket_process_overdue' => 0, // 默认未超期
                'ticket_data' => $validated['form_data'] ?? '',
                'created_at' => time(),
                'updated_at' => time(),
            ];

            // 创建工单
            $ticket = $this->ticketsModel->create($ticketData);

            DB::commit();

            // 确保返回的数据结构符合前端期望
            return [
                'data' => [
                    'id' => $ticket->id,
                    'ticket_no' => $ticket->ticket_no,
                    'title' => $ticket->ticket_name,
                    'status' => $ticket->ticket_status,
                    'priority' => $ticket->ticket_priority,
                    'process_position' => $ticket->ticket_process_position,
                    'created_at' => $ticket->created_at,
                ],
                'message' => '工单提交成功'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('工单提交失败', [
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e; // 让框架处理异常响应
        }
    }

    /**
     * 生成工单编号
     *
     * @return string
     */
    private function generateTicketNumber(): string
    {
        $date = date('Ymd');
        $prefix = 'TK' . $date;
        
        // 查找当天最大的序号
        $latestTicket = $this->ticketsModel
            ->where('ticket_no', 'like', $prefix . '%')
            ->orderBy('ticket_no', 'desc')
            ->first();

        if ($latestTicket) {
            $lastNumber = (int) substr($latestTicket->ticket_no, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * 获取工单状态选项
     *
     * @param Factory $factory
     * @return array
     */
    public function getStatusOptions(Factory $factory): array
    {
        return $factory->make('ticketStatus')->get();
    }

    /**
     * 获取优先级选项
     *
     * @param Factory $factory
     * @return array
     */
    public function getPriorityOptions(Factory $factory): array
    {
        return $factory->make('ticketPriority')->get();
    }
}