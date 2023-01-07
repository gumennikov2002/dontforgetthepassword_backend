<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceContract;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    const CREDENTIALS_NOT_CORRECT = 'Неверный email либо пароль';

    public function __invoke(AuthRequest $request, UserServiceContract $userService): JsonResponse
    {
        $authToken = $userService->authenticate($request->all());

        if (!$authToken) {
            return response()->json(['errors' => [self::CREDENTIALS_NOT_CORRECT]], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json(['token' => $authToken], Response::HTTP_OK);
    }
}
