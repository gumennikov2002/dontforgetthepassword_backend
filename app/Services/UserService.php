<?php

namespace App\Services;

use App\Contracts\UserServiceContract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceContract
{

    /**
     * User registration
     *
     * @param array $data
     * @return bool
     */
    public function register(array $data): bool
    {
        $data['password'] = Hash::make($data['password']);
        return (bool) User::create($data);
    }


    /**
     * User Authentication
     *
     * @param array $credentials
     * @return string|null
     */
    public function authenticate(array $credentials): ?string
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user->createToken($credentials['device_name'])->plainTextToken;
    }


    /**
     * Regenerate password and send it to user's email
     *
     * @param string $email
     * @return void
     */
    public function forgotPassword(string $email): void
    {
        // TODO: Implement forgotPassword() method.
    }
}
