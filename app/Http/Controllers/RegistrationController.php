<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request): JsonResponse
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        return User::create($data) ?
            response()->json(null, Response::HTTP_OK) :
            response()->json(null, Response::HTTP_FORBIDDEN);
    }
}
