<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPasswordRecoveryTest extends TestCase
{
    use RefreshDatabase;

    const TRY_URI = '/api/v1/user/forgot_password';

    /** @test */
    public function user_forgot_password()
    {
        $this->withoutExceptionHandling();

        $credentials = User::makeTestEntity();
        $response = $this->post(self::TRY_URI, ['email' => $credentials['email']]);
        $response->assertOk();
    }
}
