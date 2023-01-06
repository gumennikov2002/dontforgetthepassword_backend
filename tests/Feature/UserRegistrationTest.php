<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    const TRY_URI = '/api/v1/registration';

    /** @test */
    public function user_can_be_registered()
    {
        $this->withoutExceptionHandling();
        $testEmail = 'testuser'.Str::random(6).'@gmail.com';
        $testPassword = Str::random(6);

        $response = $this->post(self::TRY_URI, [
            'email'                 => $testEmail,
            'password'              => $testPassword,
            'password_confirmation' => $testPassword
        ]);

        $response->assertOk();
        $this->assertTrue((bool) User::where('email', $testEmail)->count());
    }

    /** @test */
    public function user_email_validation()
    {
        $testPassword = Str::random(6);
        $wrongDnsEmail = Str::random(7).'@'.Str::random(4).'.'.Str::random(2);

        $responseEmptyEmail = $this->post(self::TRY_URI, [
            'email'                 => '',
            'password'              => $testPassword,
            'password_confirmation' => $testPassword
        ]);

        $responseWrongDnsEmail = $this->post(self::TRY_URI, [
            'email'                 => $wrongDnsEmail,
            'password'              => $testPassword,
            'password_confirmation' => $testPassword
        ]);

        $this->assertTrue(
            isset($responseEmptyEmail->getOriginalContent()['errors']['email']) &&
            isset($responseWrongDnsEmail->getOriginalContent()['errors']['email'])
        );
    }

    /** @test */
    public function user_password_validation()
    {
        $testEmail = 'testuser'.Str::random(6).'@mail.ru';
        $shortPassword = Str::random(4);
        $password = Str::random(6);

        $responseEmptyPassword = $this->post(self::TRY_URI, [
            'email'    => $testEmail,
            'password' => '',
        ]);

        $responseWrongConfirmation = $this->post(self::TRY_URI, [
            'email'    => $testEmail,
            'password' => $password,
        ]);

        $responseShortPassword = $this->post(self::TRY_URI, [
            'email'    => $testEmail,
            'password' => $shortPassword
        ]);

        $this->assertTrue(
            isset($responseEmptyPassword->getOriginalContent()['errors']['password']) &&
            isset($responseWrongConfirmation->getOriginalContent()['errors']['password']) &&
            isset($responseShortPassword->getOriginalContent()['errors']['password'])
        );
    }
}
