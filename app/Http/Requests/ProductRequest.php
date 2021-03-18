<?php

namespace App\Http\Requests;

class ProductRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:200',
            'description' => 'max:1000',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'external_id' => 'numeric',
            'category_id' => 'array'
        ];
    }

}
