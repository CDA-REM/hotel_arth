<?php

namespace App\Http\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserControllerValidator
{

    static function updateUserValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            "id" => "int",
            "civility" => "in:mister,madam",
            "firstname" => "string",
            "name" => "string",
            "email" => "email",
            "phoneNumber" => "numeric|digits:10",
            "address" => "string",
            "zipCode" => "numeric",
            "city" => "string",
            "companyName" => "nullable|string",
            "companyAddress" => "nullable|string",
            "companyZipCode" => "nullable|numeric",
            "companyCity" => "nullable|string"
        ], [
            'required' => 'The :attribute field is required.',
            'date_format' => 'The :attribute field is required.',
        ]);
    }

}
