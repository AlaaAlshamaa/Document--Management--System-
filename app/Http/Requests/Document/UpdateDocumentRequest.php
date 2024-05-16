<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id'  => 'nullable|integer|exists:categories,id',
            'title'        => 'required|string|max:100|',
            'description'  => 'required|string|max:250|',
            'file'         => 'required|file|mimes:png,jpg,jpeg,pdf,doc,docx|max:10000000|',
            ];
    }
}
