<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
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
            'name' => 'required',
            'time' => 'required',
            'start_at' => 'required',
            'classroom_id' => 'required',
            'exam_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên kì thi',
            'time.required' => 'Bạn chưa nhập thời gian thi',
            'started_at.required' => 'Bạn chưa nhập thời gian bắt đầu',
            'classroom_id.required' => 'Bạn chưa nhập lớp thi',
            'exam_id.required' => 'Bạn chưa nhập đề thi',
        ];
    }
}
