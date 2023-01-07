<?php

namespace App\Services;

use App\Contracts\UserServiceContract;
use App\Mail\PasswordRecovery;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
    public function passwordRecovery(string $email): void
    {
        $user = User::where('email', $email)->first();
        $newPassword = Str::random(6);

        if (!$user) return;

        $user->update(['password' => Hash::make($newPassword)]);

        Mail::to($email)->send(new PasswordRecovery($email, $newPassword));
    }
}
