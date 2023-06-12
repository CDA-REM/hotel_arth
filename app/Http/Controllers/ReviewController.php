<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ReviewResource::collection(
            Review::query()
                ->with('user')
                ->paginate(9)
//                ->get()
        );
    }
    // query() method allows to pass other methods (ex: relation with another table) before launching the get() request

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReviewRequest $request
     * @return ReviewResource
     */
    public function store(StoreReviewRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=> 'required|int',
            'rating' => 'required|int|min:1|max:5',
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:500',
            'is_displayed' => ['required', new Boolean],

        ]);

        if ($validator->fails()) {
            return redirect('home/')
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validate();

        $review = new Review();
        $review->fill($validatedData)
            ->save();

        return new ReviewResource($review);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReviewRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(UpdateReviewRequest $request, int $id) : JsonResponse
    {
        $review = ReviewResource::make(Review::query()->findOrFail($id));
        $review->update($request->post());

        return response()->json($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        //
    }
}
