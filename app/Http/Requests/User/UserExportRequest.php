<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserExportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('view-user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'selectedId' => 'required',
            'selectedWriter' => 'required',
        ];
    }


    public function messages(): array
    {
        return [
            'selectedId' => 'Dışa aktarılacak kullanıcılar seçilmiş olmalıdır.',
            'selectedWriter' => 'Dışa aktarılacak dosya türü seçilmiş olmalıdır',
        ];
    }
}
