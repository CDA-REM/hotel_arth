<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SocialMedia::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //Data validation
        $validatedData = $request->validate([
            'logo_url' => 'required|image|mimes:jpg,jpeg,png',
            'social_url' => 'url'
        ]);

        if ($request->hasFile('logo_url')) {
            // Getting the sent file
            $file = $request->file('logo_url');
            // Minimal sanitizing of the file name (deleting all whitespace)
            $file_name = preg_replace('/\s+/', '', $file->getClientOriginalName());

            $validatedData['logo_url'] = 'storage/social_medias/' . $file_name;

            // Putting the file in said
            // directory with said filename
            Storage::putFileAs('public/social_medias', $file, $file_name);
        }


//        dd($validatedData);
        // Create a new instance of social media
        $socialM = new SocialMedia();

        //Fill $socialM with validated data and save
        $socialM->fill($validatedData)
                ->save();

        return response()->json($socialM);

//        return new SocialMedia($socialM);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'logo_url' => 'image|image|mimes:jpg,jpeg,png',
            'social_url' => 'url'
        ]);

        $socialM = SocialMedia::query()->findOrFail($id);

        if ($request->hasFile('logo_url')) {
            // Getting the sent file
            $file = $request->file('logo_url');
            // Minimal sanitizing of the file name (deleting all whitespace)
            $file_name = preg_replace('/\s+/', '', $file->getClientOriginalName());
//
            $validatedData['logo_url'] = 'storage/social_medias/' . $file_name;

            // Putting the file in said directory with said filename
            Storage::putFileAs('public/social_medias', $file, $file_name);

            // Modification of the file path in order to find it in the storage/public/social_medias
            $old_filepath = str_replace('storage/', 'public/', $socialM->logo_url);
            Storage::delete( $old_filepath );
        }

        // Updating data in database
        $socialM->update($validatedData);


        return response()->json($socialM);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        SocialMedia::destroy($id);
        return response()->json(SocialMedia::all());
    }
}
