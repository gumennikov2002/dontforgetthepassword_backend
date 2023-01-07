<?php

namespace App\Contracts;

interface UserServiceContract
{
    /**
     * Register user
     *
     * @param array $data
     * @return bool
     */
    public function register(array $data): bool;


    /**
     * Authenticate user then return token or null
     *
     * @param array $credentials
     * @return string
     */
    public function authenticate(array $credentials): ?string;



    /**
     * Password recovery
     *
     * @param string $email
     * @return bool
     */
    public function passwordRecovery(string $email): void;
}
