<?php

namespace Modules\Tickets\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidFieldArrayRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $decoded = json_decode($value, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $fail('表单配置必须是有效的JSON格式');
            return;
        }

        if (!is_array($decoded)) {
            $fail('表单配置必须是字段配置数组');
            return;
        }

        if (empty($decoded)) {
            $fail('表单配置至少需要包含一个字段');
            return;
        }

        foreach ($decoded as $index => $field) {
            if (!is_array($field)) {
                $fail("第 " . ($index + 1) . " 个字段配置必须是对象");
                return;
            }

            $requiredFields = ['name', 'label', 'type'];
            foreach ($requiredFields as $requiredField) {
                if (!isset($field[$requiredField]) || empty(trim($field[$requiredField]))) {
                    $fail("第 " . ($index + 1) . " 个字段缺少必要属性: {$requiredField}");
                    return;
                }
            }

            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $field['name'])) {
                $fail("字段 {$field['name']} 的名称格式不正确，只能包含字母、数字和下划线，且不能以数字开头");
                return;
            }

            $validTypes = ['text', 'textarea', 'number', 'date', 'select', 'radio', 'checkbox', 'switch', 'department', 'position'];
            if (!in_array($field['type'], $validTypes)) {
                $fail("字段 {$field['name']} 的type值无效，必须是: " . implode(', ', $validTypes));
                return;
            }

            $optionTypes = ['select', 'radio', 'checkbox'];
            if (in_array($field['type'], $optionTypes)) {
                if (!isset($field['options']) || empty(trim($field['options']))) {
                    $fail("字段 {$field['name']} 类型为 {$field['type']}，必须提供options选项");
                    return;
                }
            }

            if (isset($field['required']) && !is_bool($field['required'])) {
                $fail("字段 {$field['name']} 的required属性必须是布尔值");
                return;
            }

            if (isset($field['show_option']) && !empty($field['show_option'])) {
                $this->validateShowOption($field['show_option'], $field['name'], $fail);
            }
        }

        $fieldNames = array_column($decoded, 'name');
        $duplicateNames = array_diff_assoc($fieldNames, array_unique($fieldNames));
        if (!empty($duplicateNames)) {
            $fail('字段名存在重复: ' . implode(', ', $duplicateNames));
            return;
        }
    }

    /**
     * 验证显隐配置格式
     */
    private function validateShowOption(string $showOption, string $fieldName, Closure $fail): void
    {
        $rules = explode(';', $showOption);
        
        foreach ($rules as $rule) {
            if (empty(trim($rule))) {
                continue;
            }
            
            if (!str_contains($rule, '|')) {
                $fail("字段 {$fieldName} 的隐藏配置格式错误，应为: 选项值|目标字段1,目标字段2");
                return;
            }
            
            [$optionValue, $targetFields] = explode('|', $rule, 2);
            
            if (empty(trim($optionValue))) {
                $fail("字段 {$fieldName} 的隐藏配置中选项值不能为空");
                return;
            }
            
            if (empty(trim($targetFields))) {
                $fail("字段 {$fieldName} 的隐藏配置中目标字段不能为空");
                return;
            }
        }
    }
}