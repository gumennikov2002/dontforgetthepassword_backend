<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    const TRY_URI = '/api/v1/login';

    /** @test */
    public function user_can_be_logged_in()
    {
        $this->withoutExceptionHandling();

        $credentials = [...User::makeTestEntity(),
            'device_name' => 'Samsung Galaxy J1 2016'
        ];

        $response = $this->post(self::TRY_URI, $credentials);
        $response->assertOk();
    }

    /** @test */
    public function user_login_with_wrong_creds()
    {
        $this->withoutExceptionHandling();

        $credentials = [
            'email'       => Str::random(12).'@gmail.com',
            'password'    => Str::random(8),
            'device_name' => Str::random(6)
        ];

        $response = $this->post(self::TRY_URI, $credentials);
        $this->assertTrue(isset($response->getOriginalContent()['errors']));
    }

    /** @test */
    public function user_login_fields_validation()
    {
        $this->withoutExceptionHandling();

        $credentials1 = [
            'email'       => Str::random(12).'@gmail.com',
            'password'    => Str::random(8)
        ];

        $credentials2 = [
            'email'       => Str::random(12).'@gmail.com',
            'device_name' => Str::random(6)
        ];

        $credentials3 = [
            'password'    => Str::random(8),
            'device_name' => Str::random(6)
        ];

        $response1 = $this->post(self::TRY_URI, $credentials1);
        $this->assertTrue(isset($response1->getOriginalContent()['errors']['device_name']));

        $response2 = $this->post(self::TRY_URI, $credentials2);
        $this->assertTrue(isset($response2->getOriginalContent()['errors']['password']));

        $response3 = $this->post(self::TRY_URI, $credentials3);
        $this->assertTrue(isset($response3->getOriginalContent()['errors']['email']));
    }
}
