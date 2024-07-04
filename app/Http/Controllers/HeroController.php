<?php

namespace App\Http\Controllers;

use App\Http\Resources\HeroResource;
use App\Http\Resources\NewsResource;
use App\Models\Hero;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return HeroResource
     */
    public function index()
    {
        return HeroResource::make(Hero::first());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $resource = HeroResource::make(Hero::findOrFail($id));

        $validatedData = $request->post();

        if ($request->hasFile('media_url')) {
             // Getting the sent file
            $file = $request->file('media_url');
            // Minimal sanitizing of the file name (deleting all whitespace)
            $file_name = preg_replace('/\s+/', '', $file->getClientOriginalName());
            // Putting the file in said directory with said filename
            Storage::putFileAs('public/hero', $file, $file_name);
            // Swapping file to path
            $validatedData['media_url'] = '/storage/hero/' . $file_name;
            // Modifies the file path in order to find it in the storage/public/hero
            $old_filepath = str_replace('storage/', 'public/', $resource->media_url);
            Storage::delete( $old_filepath );
        }

        // Updating database data : array_filter discard all empty fields beforehand.
        $resource
            ->fill($validatedData)
            ->setTranslations('title', $request->post('title'))
            ->setTranslations('subtitle', $request->post('subtitle'));

        $resource->update();

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hero $hero)
    {
        //
    }
}
