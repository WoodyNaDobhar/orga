<?php

namespace App\Http\Requests\API;

use App\Models\Persona;
use Illuminate\Validation\Rule;

class UpdatePersonaAPIRequest extends APIRequest
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
			'chapter_id' => 'required|exists:chapters,id',
			'pronoun_id' => 'nullable|exists:pronouns,id',
			'honorific_id' => 'nullable|exists:issuances,id',
			'mundane' => 'nullable|string|max:191',
			'name' => 'required|string|max:191',
			'slug' => [
				'nullable',
				'sometimes',
				Rule::unique('personas')->ignore($this->id),
				'string',
				'max:25',
				'regex:/^(?=.*[a-zA-Z]).+$/i'
			],
			'heraldry' => 'nullable|string|max:191',
			'image' => 'nullable|string|max:191',
			'is_active' => 'required|boolean',
			'reeve_qualified_expires_at' => 'nullable|date',
			'corpora_qualified_expires_at' => 'nullable|date',
			'joined_chapter_at' => 'nullable|date'
		];
	}
}
