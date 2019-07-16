<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required',
            'answers.*' => 'required',
            'true_answer' => 'required',
            'level' => 'required',
            'topic_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'content.required' => 'Bạn chưa nhập câu hỏi',
            'answers.*' => 'Bạn chưa nhập đầy đủ các câu trả lời',
            'true_answer.required' => 'Bạn chưa nhập câu trả lời đúng',
            'level.required' => 'Bạn chưa nhập mực độ của câu hỏi',
            'topic_id.required' => 'Bạn chưa nhập chủ đề',
        ];
    }
}
