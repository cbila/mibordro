<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update-user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (auth()->user()->hasRole(['superadmin', 'admin'])) {
            return [
                'name'                  => 'required', 'string', 'max:255',
                'email'                 => 'required|unique:users,email,' . $this->user->id,
                'password'              => 'nullable', 'confirmed', Password::defaults(),
                'password_confirmation' => 'sometimes|required_with:password|same:password',
                'roles'                 => 'required',
                // 'identity'              => 'size:11',
                'sgk'                   => 'required',
                'recruitment_date'      => 'required',
                // 'iban'                  => 'max:32',
                // 'gsm'                   => 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20',
                'info'                  => 'max:255',
            ];
        } else {
            return [
                'name'                  => 'required', 'string', 'max:255',
                'email'                 => 'required|unique:users,email,' . $this->user->id,
                'password'              => 'nullable', 'confirmed', Password::defaults(),
                'password_confirmation' => 'sometimes|required_with:password|same:password',
                'roles'                 => 'required',
                // 'identity'              => 'size:11',
                'company'               => 'required',
                'sgk'                   => 'required',
                'recruitment_date'      => 'required',
                // 'iban'                  => 'max:32',
                // 'gsm'                   => 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20',
                'info'                  => 'max:255',
            ];
        }

    }

    public function messages(): array
    {
        return [
            'name.required' => 'Kullanıcı adı gereklidir.',
            'email.required' => 'E-posta gereklidir.',
            'identity.required' => 'TC Kimlik no gereklidir.',
            'identity.numeric' => 'TC Kimlik no rakamlardan oluşmalıdır.',
            'identity.size' => 'TC Kimlik no 11 rakamdan oluşmalıdır.',
            'company.required' => 'Fima  gereklidir.',
            'roles.required' => 'Rol seçilmesi gereklidir.',
            'sgk.required' => 'SGK Md. seçilmesi gereklidir.',
            'recruitment_date.required' => 'İşe giriş tarihi gereklidir.',
            'info.max' => 'Bilgi alanı 255 karakteri aşmamalıdır',
        ];
    }
}
