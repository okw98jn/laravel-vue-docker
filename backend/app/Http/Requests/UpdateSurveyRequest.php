<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $survey = $this->route('survey');

        return $this->user()->can('update', $survey);
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
            'questions'   => 'array',
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
