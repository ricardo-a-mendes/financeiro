<?php

namespace App\Http\Requests;

use App\Model\TransactionReference;
use Illuminate\Foundation\Http\FormRequest;

class TransactionReferenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $reference = TransactionReference::find($this->route('reference'));
        return $reference && $reference->account_id == $this->user()->account_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => 'required|combo'
        ];
    }
}
