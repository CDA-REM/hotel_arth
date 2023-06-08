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
//            "id" => "required|int",
//            "civility" => "required|in:mister,madame",
//            "firstname" => "required|string",
//            "lastname" => "required|string",
//            "email" => "required|email",
//            "phoneNumber" => "required|numeric|digits:10",
//            "address" => "required|string",
//            "zipCode" => "required|numeric",
//            "city" => "required|string",
//            "companyName" => "required|string",
//            "companyAddress" => "required|string",
//            "companyZipCode" => "required|numeric",
//            "companyCity" => "required|string"
            "id" => "int",
            "civility" => "in:mister,madam",
            "firstname" => "string",
            "lastname" => "string",
            "email" => "email",
            "phoneNumber" => "numeric|digits:10",
            "address" => "string",
            "zipCode" => "numeric",
            "city" => "string",
            "companyName" => "string",
            "companyAddress" => "string",
            "companyZipCode" => "numeric",
            "companyCity" => "string"
        ], [
            'required' => 'The :attribute field is required.',
            'date_format' => 'The :attribute field is required.',
        ]);
    }

}
