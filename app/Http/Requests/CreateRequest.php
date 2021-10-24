<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //guest users can also add items to basket
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
            'cart.token' => 'required|string',
            'cart.customer_id' => 'required|integer',
            'product.product_id' => 'required|integer',
            'product.option_id' => 'required|integer',
            'product.quantity' => 'required|integer',
            'product.unit_price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }
}
