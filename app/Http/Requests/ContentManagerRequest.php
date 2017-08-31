<?php

namespace App\Http\Requests;

use App\SynthesisCMS\API\Auth\UserPrivilegesManager;
use Illuminate\Foundation\Http\FormRequest;


class ContentManagerRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return UserPrivilegesManager::isContentManager();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		];
	}
}
