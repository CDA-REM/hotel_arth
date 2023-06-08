<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a user.
     ** @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validatedData->fails())
        {
            return response()->json([
                'errors' => $validatedData->errors(),
            ]);
        }else{
            $user = User::create([
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            // Delete old tokens in db
            // $user->tokens()->delete();

            //Get remember token
            $rememberToken = $user->remember_token;

            // Authenticate the user
            Auth::login($user);

            // Create a new token if user isAdmin
            if($user->role == 'admin'){
                $token = $user->createToken('auth_token')->plainTextToken;
            }else{
                $token = '';
            }

            return response()->json([
                'token' => $token,
                'user' => $user,
                'remember_token' => $rememberToken
            ]);
        }
    }

    /**
     * Display a user.
     ** @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function login(Request $request)
    {
        // Validation
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        // if validation fails
        if ($validatedData->fails())
        {
            return response()->json([
                'errors' => $validatedData->errors()
            ]);
        }

        // Check if right email and password match in database (authentication)
        $authentication = Auth::attempt(['email' => $request['email'], 'password' => $request['password']]) === true;

        // Trow an exception if authentication fails
        function checkAuthentication($response) {
            if(!$response) {
                throw new Exception("Email et/ ou mot de passe incorrecte");
            }
            return true;
        }
        try {
            // Authentication of user pass
            checkAuthentication($authentication);
            // Get user information
            $user = User::where('email', $request['email'])->firstOrFail();
            // Delete old tokens in db
            // $user->tokens()->delete();

            //Get remember token
            $rememberToken = $user->remember_token;

            // Create a new token if user isAdmin
            if($user->role == 'admin'){
                $token = $user->createToken('auth_token')->plainTextToken;
            }else{
                $token = '';
            }

            return response()->json([
                'token' => $token,
                'remember_token' => $rememberToken,
                'user' => $user,
            ]);

        }
        catch (Exception $e){
            // Authentication of user fails
            return response()->json([
                'errors' => [
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        Auth::guard("web")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

         return response()->noContent();

//        // Revoke the token that was used to authenticate the current request...
//        $request->user()->currentAccessToken()->delete();

//        return redirect('/');
    }

}
