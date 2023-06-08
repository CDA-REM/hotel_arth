<?php

namespace App\Http\Controllers;

use App\Http\Validators\UserControllerValidator;
use App\Models\User;
use App\Repository\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function user($id)
    {
        $user = User::query()->find($id);

        return response()->json($user);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $user = Auth::user();
//        if($user){
            return response()->json($user);
//        }else{
//            throw new Exception('Non');
//        }

//        $admin = $users->where('role', '=', 'Admin');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::query()->find($id);
        $dataToUpdate = $request->all();

        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->isValid()) {

                // Gets sent file
                $file = $request->file('avatar');

                // Removes whitespaces
                $file_name = preg_replace('/\s+/', '', $file->getClientOriginalName());

                // Puts the file in the storage directory
                Storage::putFileAs('public/avatars', $file, $file_name);

                // Stocker l'url de l'ancienne video dans une variable
                $old_avatar_url = $user->avatar_url;

                // Stocker le chemin vers la nouvelle video dans une variable
                $new_avatar_url = 'storage/avatars/' . $file_name;

                // indiquer la colonne à modifier en BD et ce qu'on y stocke
                $dataToUpdate['avatar'] = $new_avatar_url;

                // Modifies the file path in order to allow the server to find the video in the storage/public/hero
                $filepath = str_replace('storage/', 'public/', $old_avatar_url);

                // Supprimer le lien vers l'ancienne vidéo
                Storage::delete($filepath);
            }
        };

        // Envoyer les données mises à jour vers la DB
        $user->update($dataToUpdate);

        // Retourner le résultat de la réponse au format JSON
        return response()->json($user);
    }

    /**
     * Update a user resource in the database.
     * @param Request $request
     */
    function updateUserInfo(Request $request) {
        // Data Validation
        $validator = UserControllerValidator::updateUserValidator($request);
        if($validator->fails())
        {
            Log::error($validator->errors());
            return Response::json($validator->errors(), 502);
        }
        $validated = $validator->validated();
        Log::info("After validated data");

        return UserRepository::updateUser(User::find($validated["id"]), $validated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
