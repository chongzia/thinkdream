<?php

namespace Modules\Tickets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Tickets\Http\Rules\ValidFormSchemaRule;
use Modules\Tickets\Http\Rules\ValidFieldArrayRule;

class TicketTemplateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * 验证规则
     */
    public function rules(): array
    {
        $rules = [];
        
        // 判断是否为表单配置保存路由
        $isFormSave = $this->route()->getName() === 'ticket.template.form.save';
        
        if ($this->isMethod('POST') || $this->isMethod('PUT') || $this->isMethod('PATCH')) {
            if ($isFormSave) {
                // 表单配置保存只验证 ticket_form
                $rules = [
                    'ticket_form' => ['required', 'string', new ValidFieldArrayRule()],
                ];
            } else {
                // 完整模板验证
                $rules = [
                    'ticket_name' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('ticket_templates', 'ticket_name')->where(function ($query) {
                            // 更新时排除当前记录
                            return $query->when($this->route('template'), function ($query) {
                                $query->where('id', '<>', $this->route('template'));
                            });
                        }),
                    ],
                    'ticket_description' => 'nullable|string|max:255',
                    'ticket_form' => ['nullable', 'string', new ValidFieldArrayRule()],
                    'ticket_accept' => 'required|integer|min:1',
                    'ticket_process' => 'required|string|max:255',
                    'ticket_accept_days' => 'required|integer|min:1|max:30',
                    'ticket_process_days' => 'required|integer|min:1|max:90',
                    'ticket_is_active' => 'required|integer|in:1,2',
                ];
            }
        }
        
        // DELETE请求只需要验证资源存在（通过路由模型绑定自动处理）
        if ($this->isMethod('DELETE')) {
            $rules = [
                // 删除操作通常通过路由模型绑定验证，无需额外规则
                // 如果需要额外验证（如权限），在authorize()方法中处理
            ];
        }
        
        return $rules;
    }
    
    /**
     * 数据预处理
     */
    public function prepareForValidation(): void
    {
        // 在验证前预处理数据
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // 确保更新操作有正确的资源ID
            $this->merge([
                'template_id' => $this->route('template')
            ]);
        }
    }

    
    /**
     * 获取验证后的数据
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        
        // 清理不需要的字段
        if (isset($validated['template_id'])) {
            unset($validated['template_id']);
        }
        
        return $validated;
    }

    /**
     * 错误消息
     */
    public function messages(): array
    {
        return [
            'ticket_name.required' => '模板名称必须填写',
            'ticket_name.string' => '模板名称必须是字符串',
            'ticket_name.max' => '模板名称最多255个字符',
            'ticket_name.unique' => '模板名称已存在',
            'ticket_description.string' => '模板描述必须是字符串',
            'ticket_description.max' => '模板描述最多255个字符',
            // 'ticket_form.required' => '模板表单必须填写', // 支持分步操作
            'ticket_form.string' => '模板表单必须是字符串',
            'ticket_accept.required' => '受理人必须选择',
            'ticket_accept.integer' => '受理人必须是整数',
            'ticket_accept.min' => '受理人ID必须大于0',
            'ticket_process.required' => '流程人必须填写',
            'ticket_process.string' => '流程人必须是字符串',
            'ticket_process.max' => '流程人最多255个字符',
            'ticket_accept_days.required' => '受理天数必须填写',
            'ticket_accept_days.integer' => '受理天数必须是整数',
            'ticket_accept_days.min' => '受理天数最少1天',
            'ticket_accept_days.max' => '受理天数最多30天',
            'ticket_process_days.required' => '处理天数必须填写',
            'ticket_process_days.integer' => '处理天数必须是整数',
            'ticket_process_days.min' => '处理天数最少1天',
            'ticket_process_days.max' => '处理天数最多90天',
            'ticket_is_active.required' => '状态必须选择',
            'ticket_is_active.integer' => '状态必须是整数',
            'ticket_is_active.in' => '状态值无效，必须是0或1',
        ];
    }

    /**
     * 自定义属性名称
     */
    public function attributes(): array
    {
        return [
            'ticket_name' => '模板名称',
            'ticket_description' => '模板描述',
            'ticket_form' => '模板表单',
            'ticket_accept' => '受理人',
            'ticket_process' => '流程人',
            'ticket_accept_days' => '受理天数',
            'ticket_process_days' => '处理天数',
            'ticket_is_active' => '状态',
        ];
    }
}