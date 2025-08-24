<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'type' => 'required|in:password,wechat,wechat_mobile',
            'code' => 'required_if:typewechat',
            'account' => 'required_if:type,password',
            'password' => 'required_if:type,password',
            'phoneCode' => 'required_if:type,==,wechat_mobile',
            'avatar' => 'required_if_accepted:type,wechat,wechat_mobile',
            'username' => 'required_if_accepted:type,wechat,wechat_mobile',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'type.required' => '登录方式必填',
            'type.in' => '登录方式不支持',
            'account.required' => '手机号必填',
            'password.required' => '密码必填',
            'code.required' => '微信code丢失',
            'phoneCode.required' => '手机号快捷登录code丢失',
            'avatar.required' => '头像必填',
            'username.required' => '昵称必填',
        ];
    }
}
