<?php

namespace App\Http\Requests\Api\v1\Advert;

use App\Http\Requests\Api\v1\ApiRequest;
use App\Models\Advert;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateAdvertRequest extends ApiRequest
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
            Advert::FIELD_ID            => [
                'required',
                Rule::exists(Advert::TABLE_NAME)->where(function ($query) {
                    $query->where([
                        Advert::FIELD_ID         => $this->input(Advert::FIELD_ID),
                        Advert::FIELD_USER_ID    => Auth::user()->{User::FIELD_ID}
                    ]);
                })
            ],
            Advert::FIELD_TITLE         => 'required|string|max:100',
            Advert::FIELD_CONTENT       => 'required|string',
            Advert::FIELD_CATEGORY_ID   => 'required|exists:'.Category::TABLE_NAME.','.Category::FIELD_ID
        ];
    }

    protected function getValidatorInstance()
    {
        $this->request->add([Advert::FIELD_ID => $this->route(Advert::FIELD_ID)]);

        $validator = parent::getValidatorInstance();

        return $validator;
    }
}
