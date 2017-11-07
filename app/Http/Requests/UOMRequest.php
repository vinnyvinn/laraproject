<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UOMRequest extends FormRequest
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
        if ($this->method() == 'PUT') {
            return [
                'name' => 'required | unique:unit_of_measures,name,' . $this->unitOfMeasure->id
            ];
        }

        return [
            'name' => 'required | unique:unit_of_measures'
        ];
    }
}
