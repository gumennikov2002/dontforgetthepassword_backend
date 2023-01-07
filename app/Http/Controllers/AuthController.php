<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    const CREDENTIALS_NOT_CORRECT = 'Неверный email либо пароль';

    public function __invoke(AuthRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => [self::CREDENTIALS_NOT_CORRECT]], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken
        ], Response::HTTP_OK);
    }
}
