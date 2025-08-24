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

            // 获取第一个处理人ID（从处理人列表中提取第一个）
            $processIds = explode(',', $template->ticket_process);
            $firstProcessId = (int) trim($processIds[0]);

            // 准备工单数据
            $ticketData = [
                'ticket_no' => $ticketNo,
                'ticket_name' => $validated['title'],
                'ticket_status' => $validated['status'] ?? 4, // 提交后直接进入处理中状态
                'ticket_priority' => $validated['priority'],
                'ticket_template' => $validated['template_id'],
                'ticket_promoter' => auth()->id() ?? 1,
                'ticket_node_id' => 1,
                'ticket_node_accept' => $template->ticket_accept,
                'ticket_node_process' => $template->ticket_process,
                'ticket_process_position' => $firstProcessId, // 设置为第一个处理人ID
                'ticket_accept_days' => $template->ticket_accept_days,
                'ticket_process_days' => $template->ticket_process_days,
                'ticket_data' => $validated['form_data'] ?? '',
            ];

            // 创建工单
            $ticket = $this->ticketsModel->create($ticketData);

            DB::commit();

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
            
            throw $e;
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


}