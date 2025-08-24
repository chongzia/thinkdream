<?php

use Illuminate\Support\Facades\Route;
use Modules\Tickets\Http\Controllers\TicketsController;
use Modules\Tickets\Http\Controllers\TicketTemplatesController;
use Modules\Tickets\Http\Controllers\TicketsAppController;

Route::prefix('tickets')->group(function(){
    
	Route::adminResource('tickets', TicketsController::class);
	
	// 模板表单配置专用路由（使用更具体的路径避免冲突）
	Route::put('ticket/templates/{id}/form-config', [TicketTemplatesController::class, 'saveForm'])
		->name('ticket.template.form.save');
	Route::get('ticket/templates/{id}/form-config', [TicketTemplatesController::class, 'getForm'])
		->name('ticket.template.form.get');
	
	Route::adminResource('ticket/templates', TicketTemplatesController::class);
	
	// 获取启用状态的模板列表（用于工单创建）
	Route::get('ticket/templates/active', [TicketTemplatesController::class, 'activeTemplates'])
		->name('ticket.templates.active');
	
	// 工单应用路由组 (TicketsApp)
	Route::prefix('app')->group(function() {
		// 获取启用的模板列表
		Route::get('templates', [TicketsAppController::class, 'getTemplates'])
			->name('tickets.app.templates');
		
		// 获取模板表单配置
		Route::get('template/{templateId}/form', [TicketsAppController::class, 'getTemplateForm'])
			->where('templateId', '[0-9]+')
			->name('tickets.app.template.form');
		
		// 提交工单
		Route::post('submit', [TicketsAppController::class, 'submitTicket'])
			->name('tickets.app.submit');
		
		// 获取状态选项
		Route::get('status-options', [TicketsAppController::class, 'getStatusOptions'])
			->name('tickets.app.status.options');
		
		// 获取优先级选项
		Route::get('priority-options', [TicketsAppController::class, 'getPriorityOptions'])
			->name('tickets.app.priority.options');
	});
	
	//next
});

