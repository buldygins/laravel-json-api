<?php

namespace App\Http\Requests;

class CategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->method()) {
            case 'PUT':
            case'PATCH':
                return [
                    'name' => 'max:200',
                    'parent_id' => 'numeric',
                    'external_id' => '',
                ];
                break;
            case 'POST':
            default:
                return [
                    'name' => 'required|max:200',
                    'parent_id' => 'numeric',
                    'external_id' => 'required',
                ];
                break;
        }
    }
}
