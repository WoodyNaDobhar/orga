<?php

namespace App\Http\Requests;

use App\Models\Park;
use Illuminate\Foundation\Http\FormRequest;

class UpdateParkRequest extends FormRequest
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
        $rules = Park::$rules;
        
        return $rules;
    }
}
