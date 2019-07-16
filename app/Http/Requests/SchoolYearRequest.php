<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolYearRequest extends FormRequest
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
            'name' => 'required|unique:school_year,name,' . $this->id . ',id'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên kỳ học',
            'name.unique' => 'Tên kỳ học này đã tồn tại'
        ];
    }
}
