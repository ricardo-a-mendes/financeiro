<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        $provisionId = $this->input('id');
//        $provision = Provision::find($provisionId);
//        return ($provision->account_id == Auth::user()->account->id);
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
            'value' => 'required',
            'category' => 'required|combo',
            'transactionType' => 'required|combo',
            'specific_date' => 'required_if:specific_provision_option,yes'
        ];
    }
}
