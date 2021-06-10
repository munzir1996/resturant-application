<?php

namespace App\Http\Controllers\API\CLient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\ResturantStoreBasicInfoRequest;
use App\Http\Requests\API\Client\ResturantStoreInfoRequest;
use App\Http\Requests\API\Client\ResturantStoreRequest;
use App\Http\Requests\API\Client\ResturantUpdateRequest;
use App\Http\Resources\Client\ResturantBasicInfoCollection;
use App\Http\Resources\Client\ResturantCollection;
use App\Http\Resources\Client\ResturantInfoCollection;
use App\Http\Resources\Client\ResturantResource;
use App\Models\Client;
use App\Models\Resturant;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ResturantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resturants = Resturant::all();

        return new ResturantCollection($resturants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResturantStoreRequest $request)
    {
        $data = $request->validated();

        $resturant = Resturant::create([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'manager_name' => $data['manager_name'],
            'manager_phone' => $data['manager_phone'],
            'email' => $data['email'],
            'commercial_registration_no' => $data['commercial_registration_no'],
            'open_time' => $data['open_time'],
            'close_time' => $data['close_time'],
            'client_id' => Auth::user()->id,
        ]);

        $resturant->resturantLocation()->create([
            'latitude' => $data['latitude'],
            'longetitue' => $data['longetitue'],
        ]);

        $resturant->banks()->create([
            'name' => $data['bank_name'],
            'iban' => $data['iban'],
        ]);

        return response()->json('Resturant Created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function show(Resturant $resturant)
    {
        return new ResturantResource($resturant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function update(ResturantUpdateRequest $request, Resturant $resturant)
    {
        $data = $request->validated();

        $resturant->update([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'manager_name' => $data['manager_name'],
            'manager_phone' => $data['manager_phone'],
            'email' => $data['email'],
            'commercial_registration_no' => $data['commercial_registration_no'],
            'open_time' => $data['open_time'],
            'close_time' => $data['close_time'],
            'client_id' => Auth::user()->id,
        ]);

        $resturant->resturantLocation()->update([
            'latitude' => $data['latitude'],
            'longetitue' => $data['longetitue'],
        ]);

        $resturant->banks()->update([
            'name' => $data['bank_name'],
            'iban' => $data['iban'],
        ]);

        return response()->json('Resturant Created', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resturant $resturant)
    {
        $resturant->delete();

        return response()->json('Resturant Deleted', Response::HTTP_OK);
    }

    public function storeBasicInfo(ResturantStoreBasicInfoRequest $request)
    {
        $request->validated();

        $data = $request->validated();

        $resturant = Resturant::create([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'manager_name' => $data['manager_name'],
            'manager_phone' => $data['manager_phone'],
            'email' => $data['email'],
            'commercial_registration_no' => $data['commercial_registration_no'],
            'client_id' => Auth::user()->id,
        ]);
        $resturant->banks()->create([
            'name' => $data['bank_name'],
            'iban' => $data['iban'],
        ]);

        return response()->json('Resturant Basic Info Created', Response::HTTP_CREATED);
    }

    public function storeResturantInfo(ResturantStoreInfoRequest $request, Resturant $resturant)
    {
        $request->validated();
        $resturant->update([
            'services' => $request->services,
            'maximum_delivery_distance' => $request->maximum_delivery_distance,
            'neighborhood_delivery_price' => $request->neighborhood_delivery_price,
            'outside_neighborhood_delivery_price' => $request->outside_neighborhood_delivery_price,
            'minimum_purchase_free_delivery_in_neighborhood' => $request->minimum_purchase_free_delivery_in_neighborhood,
            'minimum_purchase_free_delivery_outside_neighborhood' => $request->minimum_purchase_free_delivery_outside_neighborhood,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'accepted_payment_methods' => $request->accepted_payment_methods,
            'loyalty_points' => $request->loyalty_points,
            'customer_earn_points' => $request->customer_earn_points,
        ]);
        $resturant->categories()->sync($request->categories);
        $resturant->resturantLocation()->create([
            'latitude' => $request->latitude,
            'longetitue' => $request->longetitue,
        ]);

        return response()->json('Resturant Info Created', Response::HTTP_CREATED);
    }

    public function getBasicInformation(Client $client)
    {
        return new ResturantBasicInfoCollection($client->resturants);
    }

    public function getResturantInfo(Client $client)
    {
        return new ResturantInfoCollection($client->resturants);
    }

    public function getServices()
    {
        return config('constants.restaurant_services', Response::HTTP_OK);
    }

    public function getPaymentMethods()
    {
        return config('constants.payment_methods', Response::HTTP_OK);
    }
}


