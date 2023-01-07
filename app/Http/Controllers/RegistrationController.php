<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceContract;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request, UserServiceContract $userService): JsonResponse
    {
        return $userService->register($request->all()) ?
            response()->json(null, Response::HTTP_OK) :
            response()->json(null, Response::HTTP_FORBIDDEN);
    }
}
