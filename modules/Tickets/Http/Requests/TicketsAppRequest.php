<?php

declare(strict_types=1);

namespace Modules\Tickets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * 工单应用请求验证类
 */
class TicketsAppRequest extends FormRequest
{
    /**
     * 确定用户是否有权发出此请求
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 获取应用于请求的验证规则
     */
    public function rules(): array
    {
        $method = $this->getMethod();

        if ($method === 'POST') {
            return $this->submitRules();
        }

        return [];
    }

    /**
     * 工单提交验证规则
     */
    private function submitRules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'min:2',
            ],
            'priority' => [
                'required',
                'integer',
                Rule::in([1, 2, 3]),
            ],
            'template_id' => [
                'required',
                'integer',
                'exists:ticket_templates,id',
            ],
            'form_data' => [
                'nullable',
                'string',
            ],
            'status' => [
                'nullable',
                'integer',
                Rule::in([1, 2, 3, 4]),
            ],
        ];
    }

    /**
     * 获取验证错误的自定义属性名称
     */
    public function attributes(): array
    {
        return [
            'title' => '工单标题',
            'priority' => '优先级',
            'template_id' => '模板ID',
            'form_data' => '表单数据',
            'status' => '工单状态',
        ];
    }

    /**
     * 获取自定义验证消息
     */
    public function messages(): array
    {
        return [
            'title.required' => '工单标题不能为空',
            'title.min' => '工单标题至少需要2个字符',
            'title.max' => '工单标题不能超过255个字符',
            'priority.required' => '请选择优先级',
            'priority.in' => '优先级选择无效',
            'template_id.required' => '请选择工单模板',
            'template_id.exists' => '选择的模板不存在',
            'status.in' => '工单状态选择无效',
        ];
    }

    /**
     * 处理验证失败
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors()->all();
        
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'code' => 422,
                'message' => '数据验证失败',
                'errors' => $errors,
                'data' => null,
            ], 422)
        );
    }

    /**
     * 配置验证器实例
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // 验证 form_data 是否为有效的 JSON
            if ($this->filled('form_data')) {
                $formData = $this->input('form_data');
                if (!is_null($formData) && !is_string($formData)) {
                    $validator->errors()->add('form_data', '表单数据格式无效');
                    return;
                }
                
                if ($formData && json_decode($formData) === null && json_last_error() !== JSON_ERROR_NONE) {
                    $validator->errors()->add('form_data', '表单数据必须是有效的JSON格式');
                }
            }
        });
    }
}