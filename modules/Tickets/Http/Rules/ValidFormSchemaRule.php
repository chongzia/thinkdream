<?php

namespace Modules\Tickets\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidFormSchemaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 首先检查是否为有效JSON
        $decoded = json_decode($value, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $fail('表单字段配置必须是有效的JSON格式');
            return;
        }

        // 检查是否有必要的属性
        if (!is_array($decoded) || !isset($decoded['type']) || $decoded['type'] !== 'object') {
            $fail('表单字段配置必须包含type属性且值为object');
            return;
        }

        // 检查是否有properties属性
        if (!isset($decoded['properties']) || !is_array($decoded['properties'])) {
            $fail('表单字段配置必须包含properties属性且为对象');
            return;
        }

        // 检查properties是否为空
        if (empty($decoded['properties'])) {
            $fail('表单字段配置至少需要包含一个字段');
            return;
        }

        // 验证每个字段的结构
        foreach ($decoded['properties'] as $fieldName => $fieldConfig) {
            if (!is_array($fieldConfig)) {
                $fail("字段 {$fieldName} 的配置必须是对象");
                return;
            }

            // 检查必要的字段属性
            if (!isset($fieldConfig['type'])) {
                $fail("字段 {$fieldName} 必须包含type属性");
                return;
            }

            if (!isset($fieldConfig['title'])) {
                $fail("字段 {$fieldName} 必须包含title属性");
                return;
            }

            // 检查type值是否有效
            $validTypes = ['string', 'number', 'integer', 'boolean', 'array'];
            if (!in_array($fieldConfig['type'], $validTypes)) {
                $fail("字段 {$fieldName} 的type值无效，必须是: " . implode(', ', $validTypes));
                return;
            }
        }

        // 检查required属性（如果存在）
        if (isset($decoded['required']) && !is_array($decoded['required'])) {
            $fail('required属性必须是数组');
            return;
        }

        // 验证required中的字段是否在properties中存在
        if (isset($decoded['required'])) {
            foreach ($decoded['required'] as $requiredField) {
                if (!isset($decoded['properties'][$requiredField])) {
                    $fail("必填字段 {$requiredField} 在properties中不存在");
                    return;
                }
            }
        }
    }
}