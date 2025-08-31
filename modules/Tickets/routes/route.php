<?php

use Illuminate\Support\Facades\Route;
use Modules\Tickets\Http\Controllers\TicketsController;
use Modules\Tickets\Http\Controllers\TicketTemplatesController;
use Modules\Tickets\Http\Controllers\TicketsAppController;

Route::prefix('tickets')->group(function(){
    
	Route::adminResource('tickets', TicketsController::class);
	
	// 工单回复相关路由
	Route::get('tickets/{id}/replies', [TicketsController::class, 'getReplies'])
		->name('tickets.replies.index');
	Route::post('tickets/{id}/replies', [TicketsController::class, 'addReply'])
		->name('tickets.replies.store');
	
	// 模板表单配置专用路由（使用更具体的路径避免冲突）
	Route::put('ticket/templates/{id}/form-config', [TicketTemplatesController::class, 'saveForm'])
		->name('ticket.template.form.save');
	Route::get('ticket/templates/{id}/form-config', [TicketTemplatesController::class, 'getForm'])
		->name('ticket.template.form.get');
	
	Route::adminResource('ticket/templates', TicketTemplatesController::class);
	

	
	// 工单应用路由组 (TicketsApp) - 无需权限验证
	Route::withoutMiddleware([
		\Modules\Permissions\Middlewares\PermissionGate::class,
	])->prefix('app')->group(function() {
		// 获取启用的模板列表
		Route::get('templates', [TicketsAppController::class, 'getTemplates'])
			->name('tickets.app.templates');
		
		// 提交工单
		Route::post('submit', [TicketsAppController::class, 'submitTicket'])
			->name('tickets.app.submit');
	});
	
	//next
});

