<?php

namespace App\Http\Requests;

use App\Models\Title;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTitleRequest extends FormRequest
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
        $rules = Title::$rules;
        
        return $rules;
    }
}
