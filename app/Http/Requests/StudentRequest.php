<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'students.*.name' => 'required',
            'students.*.birthday' => 'required|date',
            'students.*.gender' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'students.*.name.required' => 'Họ tên sinh viên không thể thiếu',
            'students.*.birthday.required' => 'Ngày sinh không thể thiếu',
            'students.*.birthday.date' => 'Không đúng định dạng ngày tháng',
            'students.*.gender.required' => 'Giới tính không thể thiếu'
        ];
    }
}
