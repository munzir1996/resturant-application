<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\MealStoreRequest;
use App\Http\Requests\API\Client\MealUpdateRequest;
use App\Http\Resources\Client\MealCollection;
use App\Http\Resources\Client\MealResource;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meals = Meal::all();

        return new MealCollection($meals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MealStoreRequest $request)
    {
        $request->validated();

        Meal::create([
            'name' => $request->name,
            'classification_id' => $request->classification_id,
            'price' => $request->price,
            'detail' => $request->detail,
            'calorie' => $request->calorie,
            'size' => $request->size,
            'additions' => $request->additions,
        ]);

        return response()->json('Meal Created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        return new MealResource($meal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(MealUpdateRequest $request, Meal $meal)
    {
        $request->validated();

        $meal->update([
            'name' => $request->name,
            'classification_id' => $request->classification_id,
            'price' => $request->price,
            'detail' => $request->detail,
            'calorie' => $request->calorie,
            'size' => $request->size,
            'additions' => $request->additions,
        ]);

        return response()->json('Meal Updated' , Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        $meal->delete();

        return response()->json('Meal Deleted', Response::HTTP_OK);
    }
}
