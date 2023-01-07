<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceContract;
use App\Http\Requests\PasswordRecoveryRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * Password recovery
     *
     * @param PasswordRecoveryRequest $request
     * @param UserServiceContract $service
     * @return JsonResponse
     */
    public function forgotPassword(PasswordRecoveryRequest $request, UserServiceContract $service): JsonResponse
    {
        $service->passwordRecovery($request->email);
        return response()->json(null, Response::HTTP_OK);
    }
}
