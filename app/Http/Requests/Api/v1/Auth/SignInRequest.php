<?php

namespace App\Http\Requests\Api\v1\Auth;

use App\Http\Requests\Api\v1\ApiRequest;
use App\Models\User;
use App\Rules\PasswordRules;
use Illuminate\Support\Facades\Config;

class SignInRequest extends ApiRequest
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
            User::FIELD_EMAIL       => 'required|email|exists:'.User::TABLE_NAME,
            User::FIELD_PASSWORD    => 'required|string'
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        return $validator;
    }
}
