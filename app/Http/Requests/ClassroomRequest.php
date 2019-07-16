<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:classrooms,name,' . $this->id . ',id'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên lớp học',
            'name.unique' => 'Lớp học đã tồn tại'
        ];
    }
}
