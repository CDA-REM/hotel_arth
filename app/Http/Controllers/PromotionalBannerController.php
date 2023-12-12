<?php

namespace App\Http\Controllers;

use App\Http\Resources\PromotionalBannerResource;
use App\Models\PromotionalBanner;
use Illuminate\Http\Request;

class PromotionalBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PromotionalBannerResource
     */
    public function index()
    {
        return PromotionalBannerResource::make(PromotionalBanner::first());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //Get the data from the DB
        $resource =  PromotionalBannerResource::make(PromotionalBanner::findOrFail($id));

        // Update the data in the DB
        $resource->update($request->all());

        // Return the result of the response in JSON
        return response()->json($resource);
    }

}
