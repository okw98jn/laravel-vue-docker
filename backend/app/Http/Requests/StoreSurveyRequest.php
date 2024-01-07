<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'image'       => 'nullable|string',
            'user_id'     => 'exists:users,id',
            'status'      => 'required|boolean',
            'description' => 'nullable|string|',
            'expire_data' => 'nullable|date|after:tomorrow',
        ];
    }

    public function attributes(): array
    {
        return [
            'title'       => 'タイトル',
            'image'       => '画像',
            'user_id'     => 'ユーザーID',
            'status'      => 'ステータス',
            'description' => '説明',
            'expire_data' => '有効期限',
        ];
    }
}
