<?php

namespace App\Http\Requests;

use App\Models\Reconciliation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReconciliationRequest extends FormRequest
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
        $rules = Reconciliation::$rules;
        
        return $rules;
    }
}
