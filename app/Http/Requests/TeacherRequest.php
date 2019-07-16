<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required',
            'birthday' => 'required|date',
            'subject' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Họ tên sinh viên không thể thiếu',
            'birthday.required' => 'Ngày sinh không thể thiếu',
            'birthday.date' => 'Không đúng định dạng ngày tháng',
            'subject.required' => 'Hãy chọn tên môn học'
        ];
    }
}
