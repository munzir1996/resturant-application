<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\ClassificationStoreRequest;
use App\Http\Requests\API\Client\ClassificationUpdateRequest;
use App\Http\Resources\Client\ClassificationCollection;
use App\Http\Resources\Client\ClassificationResource;
use App\Models\Classification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classifications = Classification::all();

        return new ClassificationCollection($classifications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassificationStoreRequest $request)
    {
        $request->validated();

        Classification::create([
            'name' => $request->name,
            'resturant_id' => $request->resturant_id,
        ]);

        return response()->json('Classification Created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function show(Classification $classification)
    {
        return new ClassificationResource($classification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function update(ClassificationUpdateRequest $request, Classification $classification)
    {
        $request->validated();

        $classification->update([
            'name' => $request->name,
            'resturant_id' => $request->resturant_id,
        ]);

        return response()->json('Classification Updated', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classification $classification)
    {
        $classification->delete();

        return response()->json('Classification Deleted', Response::HTTP_OK);
    }
}
