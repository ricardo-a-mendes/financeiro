<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'description' => 'required',
			'transaction_value' => 'required',
			'transaction_date' => 'required',
			'category' => 'required|combo',
			'account' => 'required|combo',
			'transactionType' => 'required|combo',
        ];
    }
}
