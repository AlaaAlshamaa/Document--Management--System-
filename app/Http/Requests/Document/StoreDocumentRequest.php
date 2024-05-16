<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'category_id'  => 'required|integer|exists:categories,id',
            'title'        => 'required|string|max:100|',
            'description'  => 'required|string|max:250|',
            'file'         => 'required|file|mimes:png,jpg,jpeg,pdf,doc,docx|max:10000000|',
            'tags'         => 'required|array'
        ];
    }
}
