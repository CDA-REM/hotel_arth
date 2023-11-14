<?php

namespace App\Http\Controllers;

use App\Http\Validators\UserControllerValidator;
use App\Models\User;
use App\Repository\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Nette\Schema\ValidationException;
use function PHPUnit\Framework\throwException;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function user($id)
    {
        $user = User::query()->find($id);

        return response()->json($user);

    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function me(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            return response()->json([
                'user'=> $user,
            ]);
        }else{
            abort('401');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
//        if($user){
            return response()->json($user);
//        }else{
//            throw new Exception('Non');
//        }

//        $admin = $users->where('user_role', '=', 'Admin');
//       $admin = Auth::check();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool
     */
    public function create(User $user)
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Updates the user's avatar.
     *
     * @param Request $request The HTTP request object.
     * @param User $user The user object to update.
     * @return bool Returns true if the avatar is successfully updated, false otherwise.
     * @throws Exception If there is an error storing the avatar file.
     */
    private function updateUserAvatar(Request $request, User $user): bool
    {
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $file = $request->file('avatar');
            $file_name = preg_replace('/\s+/', '', $file->getClientOriginalName());

            try {
                // Le chemin relatif où le fichier sera stocké dans le système de fichiers public
                $relativePath = 'users/' . $file_name;

                // Stockage du fichier dans le système de fichiers
                Storage::putFileAs('public/avatars', $file, $file_name);

                // Construction de l'URL complète de l'avatar
                $new_avatar_url = 'storage/avatars/' . $file_name;

                if (!empty($user->avatar_url)) {
                    // Suppression de l'ancien fichier avatar, si nécessaire
                    $old_avatar_path = str_replace('storage/avatars/', 'public/avatars/', $user->avatar_url);
                    Storage::delete($old_avatar_path);
                }

                // Mise à jour des colonnes avatar et avatar_url
                $user->avatar = $relativePath;
                $user->avatar_url = $new_avatar_url;
                $user->save();

                return true;
            } catch (Exception $e) {
                Log::error("Error storing avatar file: " . $e->getMessage());
                return false;
            }
        }
        return false;
    }

    /**
     * Update a user based on the given request data.
     *
     * @param Request $request The request object containing the user data.
     * @return JsonResponse The JSON response containing the updated user and the avatar update status.
     */
    public function update(Request $request): JsonResponse
    {
        // Data Validation
        $validator = UserControllerValidator::updateUserValidator($request);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Response::json($validator->errors(), 502);
        }
        $validated = $validator->validated();
        Log::info("After validated data");

        // Find user
        $user = User::find($validated["id"]);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update avatar
        $avatarUpdatedSuccessfully = $this->updateUserAvatar($request, $user);

        // Update user using the repository, regardless of avatar update status
        $updatedUser = UserRepository::updateUser($user, $validated);

        // Include avatar update status in the response
        return response()->json([
            'user' => $updatedUser,
            'avatarUpdated' => $avatarUpdatedSuccessfully
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);
            return response()->json(['Ok'], 200);
        }catch (Exception $e){
            return response()->json($e);
        }

    }
}
