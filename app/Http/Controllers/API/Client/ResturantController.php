<?php

namespace App\Http\Controllers\API\CLient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Client\ResturantStoreBasicInformationRequest;
use App\Http\Requests\API\Client\ResturantStoreRequest;
use App\Http\Requests\API\Client\ResturantUpdateRequest;
use App\Http\Resources\Client\ResturantBasicInfoCollection;
use App\Http\Resources\Client\ResturantCollection;
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
            'delivery' => $data['delivery'],
            'category_id' => $data['category_id'],
            'client_id' => Auth::user()->id,
        ]);

        $resturant->resturantLocation()->create([
            'latitude' => $data['latitude'],
            'longetitue' => $data['longetitue'],
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
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
            'delivery' => $data['delivery'],
            'category_id' => $data['category_id'],
            'client_id' => Auth::user()->id,
        ]);

        $resturant->resturantLocation()->update([
            'latitude' => $data['latitude'],
            'longetitue' => $data['longetitue'],
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
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

    public function storeBasicInformation(ResturantStoreBasicInformationRequest $request)
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

    public function getBasicInformation(Client $client)
    {
        return new ResturantBasicInfoCollection($client->resturants);
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


