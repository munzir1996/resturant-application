<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\ClientAuthRegisterRequest;
use App\Http\Requests\API\Auth\ClientProfileRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ClientAuthController extends Controller
{

    public function register(ClientAuthRegisterRequest $request)
    {
        $data = $request->validated();

        $client = Client::create([
            'name' => $data['name'],
            // 'email' => $data['email'],
            'phone' => $data['phone'],
            'country' => $data['country'],
            'job' => $data['job'],
            'identity_no' => $data['identity_no'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'client' => $client->only(['id', 'name', 'phone', 'country', 'job', 'identity_no']),
            'token' => $client->createToken('mobile-client', ['role:client'])->plainTextToken,
        ], Response::HTTP_CREATED);

    }

    public function updateProfile(ClientProfileRequest $request)
    {
        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        }

        auth()->user()->update($data);

        return response()->json(auth()->user()->only(['id', 'name', 'phone', 'country', 'job', 'identity_no']), Response::HTTP_OK);
    }

    public function login(Request $request)
    {
        $request->validate([
            'identity' => 'required',
            'password' => 'required',
        ]);

        $field = filter_var($request->identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $client = Client::where("{$field}", $request->identity)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            throw ValidationException::withMessages([
                'identity' => ['بيانات الاعتماد المقدمة غير صحيحة.'],
            ]);
        }

        return response()->json([
            'client' => $client->only(['id', 'name', 'phone']),
            'token' => $client->createToken('mobile-client', ['role:client'])->plainTextToken,
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json('Client Logged out', Response::HTTP_OK);
    }

}





