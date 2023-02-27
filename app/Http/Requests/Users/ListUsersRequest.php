<?php

namespace App\Http\Requests\Users;

use App\Enums\Ordination;
use App\Helpers\HasClaim;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

class ListUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return HasClaim::verify('list:users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search' => 'string|nullable',
            'role_id' => 'integer|nullable',
            'page' => 'integer|nullable',
            'order_by' => 'string|nullable',
            'direction' => [new Enum(Ordination::class), 'nullable']
        ];
    }

    /**
     * Throws an exception if the validation rules not match.
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
