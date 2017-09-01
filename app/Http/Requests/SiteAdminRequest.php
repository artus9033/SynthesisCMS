<?php

namespace App\Http\Requests;

use App\SynthesisCMS\API\Auth\UserPrivilegesManager;
use Illuminate\Foundation\Http\FormRequest;

class SiteAdminRequest extends FormRequest
{
	//TODO: implement roles
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return UserPrivilegesManager::isSiteAdministrator();
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
