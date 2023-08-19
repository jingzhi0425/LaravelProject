<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => [
                'required'
            ],
            'bar_code_id' => [
                'required',
                'unique:products,bar_code_id,' . request()->route('product')->id,
            ],
            'image_id' => [
                'required',
            ],
            'product_category_id' => [
                'required',
            ],
        ];
    }
}
