<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\ResturantServiceStoreRequest;
use App\Http\Requests\API\Client\ResturantServiceUpdateRequest;
use App\Http\Resources\Client\ResturantServiceCollection;
use App\Http\Resources\Client\ResturantServiceResource;
use App\Models\ResturantService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ResturantServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resturantServices = ResturantService::all();

        return new ResturantServiceCollection($resturantServices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResturantServiceStoreRequest $request)
    {
        $request->validated();

        ResturantService::create([
            'name' => $request->name,
            'resturant_id' => $request->resturant_id,
        ]);

        return response()->json('Resturant Service Created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResturantService  $resturantService
     * @return \Illuminate\Http\Response
     */
    public function show(ResturantService $resturantService)
    {
        return new ResturantServiceResource($resturantService);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResturantService  $resturantService
     * @return \Illuminate\Http\Response
     */
    public function update(ResturantServiceUpdateRequest $request, ResturantService $resturantService)
    {
        $request->validated();

        $resturantService->update([
            'name' => $request->name,
            'resturant_id' => $request->resturant_id,
        ]);

        return response()->json('Resturant Service Updated', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResturantService  $resturantService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResturantService $resturantService)
    {
        $resturantService->delete();

        return response()->json('Resturant Service Deleted', Response::HTTP_OK);
    }
}
