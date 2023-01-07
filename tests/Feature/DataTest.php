<?php

namespace Tests\Feature;

use App\Models\Data;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class DataTest extends TestCase
{
    use RefreshDatabase;

    const TRY_URI = '/api/v1/data';

    /** @test */
    public function access_to_data()
    {
        $response = $this->post(self::TRY_URI.'/create', headers: [
            'Authorization' => 'Bearer '.Str::random(16)
        ]);

        $this->assertTrue((bool) $response->exception);
    }

    /** @test */
    public function create_data_validation()
    {
        $this->withoutExceptionHandling();

        $fields1 = ['password' => Str::random(6)];
        $fields2 = ['source' => 'Instagram'];

        $response1 =  $this->post(self::TRY_URI.'/create', $fields1, [
            'Authorization' => 'Bearer '.$this->getAuthToken([
                    ...User::makeTestEntity(), 'device_name' => 'Xiaomi mi 9'
                ])
        ]);

        $response2 =  $this->post(self::TRY_URI.'/create', $fields2, [
            'Authorization' => 'Bearer '.$this->getAuthToken([
                    ...User::makeTestEntity(), 'device_name' => 'Xiaomi mi 9'
                ])
        ]);

        $this->assertTrue(
            isset($response1->getOriginalContent()['errors']['source']) &&
            isset($response2->getOriginalContent()['errors']['password'])
        );
    }

    /** @test */
    public function create_data()
    {
        $this->withoutExceptionHandling();

        $fields = [
            'email'        => Str::random(5).'@gmail.com',
            'login'        => Str::random(4),
            'phone_number' => null,
            'phrase'       => null,
        ];

        $requiredFields = [
            'source'      => 'Instagram',
            'password'    => Str::random(6),
        ];

        $response = $this->post(self::TRY_URI.'/create', [...$requiredFields, ...$fields], [
            'Authorization' => 'Bearer '.$this->getAuthToken([
                ...User::makeTestEntity(), 'device_name' => 'Xiaomi mi 9'
            ])
        ]);
        $response->assertOk();
        $this->assertCount(1, Data::all());
    }

    /** @test */
    public function delete_data_validation()
    {
        $response = $this->post(self::TRY_URI.'/delete', headers: [
            'Authorization' => 'Bearer '.$this->getAuthToken([
                ...User::makeTestEntity(), 'device_name' => 'Xiaomi mi 9'
            ])
        ]);

        $this->assertTrue(isset($response->getOriginalContent()['errors']['id']));
    }

    /** @test */
    public function delete_data()
    {
        $this->withoutExceptionHandling();

        $userCredentials = User::makeTestEntity();
        $token = $this->getAuthToken([
            ...$userCredentials, 'device_name' => 'Xiaomi mi 9'
        ]);

        $response = $this->post(self::TRY_URI.'/create', [
            'email'        => Str::random(5).'@gmail.com',
            'login'        => null,
            'phone_number' => '+12783682121',
            'phrase'       => null,
            'source'       => 'Vk',
            'password'     => Str::random(6),
        ], [
            'Authorization' => 'Bearer '.$token
        ]);

        $dataId = $response->getOriginalContent()->id;

        $response = $this->post(self::TRY_URI.'/delete', ['id' => $dataId], [
            'Authorization' => 'Bearer '.$token
        ]);

        $response->assertOk();
        $this->assertTrue(!Data::find($dataId));
    }

    /** @test */
    public function update_data_validation()
    {
        $response = $this->post(self::TRY_URI.'/update', headers: [
            'Authorization' => 'Bearer '.$this->getAuthToken([
                    ...User::makeTestEntity(), 'device_name' => 'Xiaomi mi 9'
                ])
        ]);

        $this->assertTrue(isset($response->getOriginalContent()['errors']['id']));
    }

    /** @test */
    public function update_data()
    {
        $this->withoutExceptionHandling();

        $userCredentials = User::makeTestEntity();
        $token = $this->getAuthToken([
            ...$userCredentials, 'device_name' => 'Xiaomi mi 9'
        ]);

        $response = $this->post(self::TRY_URI.'/create', [
            'email'        => Str::random(2).'@ya.com',
            'login'        => null,
            'phone_number' => '+12583682121',
            'phrase'       => null,
            'source'       => 'Vk',
            'password'     => Str::random(12),
        ], [
            'Authorization' => 'Bearer '.$token
        ]);

        $dataId = $response->getOriginalContent()->id;
        $updates = ['phone_number' => '+79047826762'];

        $response = $this->post(self::TRY_URI.'/update', ['id' => $dataId, ...$updates], [
            'Authorization' => 'Bearer '.$token
        ]);

        $response->assertOk();
        $this->assertTrue(Data::find($dataId)->phone_number === $updates['phone_number']);
    }

    /** @test */
    public function get_all_data()
    {
        $this->withoutExceptionHandling();

        $userCredentials = User::makeTestEntity();
        $token = $this->getAuthToken([
            ...$userCredentials, 'device_name' => 'Xiaomi mi 9'
        ]);

        $responseSource1 = $this->post(self::TRY_URI.'/create', [
            'email'        => Str::random(2).'@ya.com',
            'login'        => null,
            'phone_number' => '+12583682121',
            'phrase'       => null,
            'source'       => 'Vk',
            'password'     => Str::random(12),
        ], [
            'Authorization' => 'Bearer '.$token
        ]);

        $responseSource2 = $this->post(self::TRY_URI.'/create', [
            'email'        => Str::random(5).'@gmail.com',
            'login'        => 'realKiller228',
            'phone_number' => null,
            'phrase'       => null,
            'source'       => 'World Of Tanks',
            'password'     => Str::random(12),
        ], [
            'Authorization' => 'Bearer '.$token
        ]);

        $responseSource3 = $this->post(self::TRY_URI.'/create', [
            'email'        => Str::random(5).'@gmail.com',
            'login'        => null,
            'phone_number' => null,
            'phrase'       => null,
            'source'       => 'Rockstar Games',
            'password'     => Str::random(12),
        ], [
            'Authorization' => 'Bearer '.$token
        ]);

        $responseSource1->assertOk();
        $responseSource2->assertOk();
        $responseSource3->assertOk();

        $responseGetAll = $this->post(self::TRY_URI.'/get_all', headers: [
            'Authorization' => 'Bearer '.$token
        ]);

        $responseGetAll->assertOk();
        $this->assertCount(3, Data::all());
    }

    /** @test */
    public function get_data_by_id_validation()
    {
        $response = $this->post(self::TRY_URI.'/get_by_id', headers: [
            'Authorization' => 'Bearer '.$this->getAuthToken([
                    ...User::makeTestEntity(), 'device_name' => 'Xiaomi mi 9'
                ])
        ]);

        $this->assertTrue(isset($response->getOriginalContent()['errors']['id']));
    }

    /** @test */
    public function get_data_by_id()
    {
        $this->withoutExceptionHandling();

        $userCredentials = User::makeTestEntity();
        $token = $this->getAuthToken([
            ...$userCredentials, 'device_name' => 'Xiaomi mi 9'
        ]);

        $responseCreate = $this->post(self::TRY_URI.'/create', [
            'email'        => Str::random(2).'@ya.com',
            'login'        => null,
            'phone_number' => '+12583682121',
            'phrase'       => null,
            'source'       => 'Vk',
            'password'     => Str::random(12),
        ], [
            'Authorization' => 'Bearer '.$token
        ]);
        $responseCreate->assertOk();

        $response = $this->post(self::TRY_URI.'/get_by_id',
            ['id' => $responseCreate->getOriginalContent()->id],
            ['Authorization' => 'Bearer '.$token]
        );
        $response->assertOk();
    }

    private function getAuthToken(array $credentials): ?string
    {
        return (new UserService)->authenticate($credentials);
    }
}
