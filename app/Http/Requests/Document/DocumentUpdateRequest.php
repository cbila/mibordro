<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update-document');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category'      => 'required',
            'date'          => 'required',
            'alias'         => 'required|max:100',
            'description'   => 'max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'category.required' => 'Kategori seçilmesi gereklidir',
            'alias.required' => 'Dosya adı gereklidir',
            'alias.date' => 'Ait olduğu ay gereklidir',
            'description.max' => 'Açıklama 255 karaktarden fazla olamaz',
        ];
    }
}
