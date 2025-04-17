<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create-document');

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
            'alias'         => 'required|max:100',
            'date'          => 'required',
            'file'          => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:500000',
            'description'   => 'max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'category.required' => 'Kategori seçilmesi gereklidir',
            'alias.required' => 'Dosya adı gereklidir',
            'date.required' => 'Dokümanın ait olduğu tarih gereklidir',
            'file.required' => 'Dosya seçilmesi gereklidir',
            'file.mimes' => 'Desteklenen dosya formatları pdf, doc, docx, xls, xlsx, ppt, pptx, jpg, jpeg ve png\'dir',
            'description.max' => 'Açıklama 255 karaktarden fazla olamaz',
        ];
    }
}
