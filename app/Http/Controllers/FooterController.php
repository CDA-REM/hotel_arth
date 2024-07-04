<?php

namespace App\Http\Controllers;

use App\Http\Resources\FooterResource;
use Illuminate\Http\Request;
use App\Models\Footer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return FooterResource::collection(Footer::all());
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
        $validator = Validator::make($request->all(), [
            'column_number' => 'required|in:1,2',
            'entry_name' => 'required|array|min:2',
            'url_redirection' => 'required'
        ]);
        if($validator->fails()){
            Log::error($validator->errors());
            return response()->json($validator->errors(), 400);
        }
        $validatedData = $validator->validate();

        // Create a new instance of footer
        $footer = new Footer();
//        dd($footer);
        //Fill $footer with validated data and save
        $footer->fill($validatedData)
               ->save();
//        return FooterResource::collection(Footer::all());
        return response()->json($footer);
//        return new FooterResource($footer);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {

        $footer = Footer::query()->findOrFail($id);
        $validator = Validator::make($request->post(), [
            'column_number' => 'in:1,2',
            'entry_name' => 'array|min:2',
        ]);

        if ($validator->fails()) {
            Log::error($validator->errors());
            return response()->json($validator->errors(), 400);
        }
        // Update data in database
        $footer->update($request->post());

        return response()->json($footer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $footer = Footer::query()->findOrFail($id);
        $footer->delete();
        return response()->json($footer);

    }
}
