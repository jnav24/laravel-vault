<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Role;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAccessControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        Role::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testGenerateMFAWithNoAppIDReturnsError()
    {
        $this->postJson(route('api.generate'))
            ->assertForbidden();
    }

    public function testGenerateMFAWithInvalidAppIDReturnsError()
    {
        $this->postJson(route('api.generate', ['app_key' => 'invalid-app-id']))
            ->assertForbidden();
    }

    public function testGenerateMFAWithWrongHostReturnsError()
    {
        $site = Site::factory()->for($this->user)->make(['domain' => 'google.com']);

        $this->postJson(route('api.generate', ['app_key' => $site->app_key]))->assertForbidden();
    }

    public function testGenerateMFAReturnSuccess()
    {
        $site = Site::factory()->for($this->user)->create(['domain' => 'localhost']);

        $this->postJson(route('api.generate', ['app_key' => $site->app_key]))
            ->assertOk()
            ->assertJsonPath('success', true);
    }

    public function testVerifyWithInvalidCodeReturnsError()
    {
        $site = Site::factory()->for($this->user)->create(['domain' => 'localhost']);

        $response = $this->postJson(route('api.generate', ['app_key' => $site->app_key]))
            ->assertOk();

        $token = $response['token'];

        $this->postJson(route('api.verify', ['app_key' => $site->app_key, 'token' => $token, 'code' => '000000']))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['challenge' => 'The provided code was invalid.']);
    }

    public function testVerifyWithMissingReturnsError()
    {
        $site = Site::factory()->for($this->user)->create(['domain' => 'localhost']);

        $response = $this->postJson(route('api.generate', ['app_key' => $site->app_key]))
            ->assertOk();

        $token = $response['token'];

        $this->postJson(route('api.verify', ['app_key' => $site->app_key, 'token' => $token]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['code' => 'The code field is required.']);
    }

    public function testDeleteReturnsSuccess()
    {
        $site = Site::factory()->for($this->user)->create(['domain' => 'localhost']);

        $response = $this->postJson(route('api.generate', ['app_key' => $site->app_key]))
            ->assertOk();

        $token = $response['token'];

        $this->deleteJson(route('api.delete', ['app_key' => $site->app_key, 'token' => $token]))->assertOk();
    }

    public function testDeleteWithInvalidTokenReturnsError()
    {
        $site = Site::factory()->for($this->user)->create(['domain' => 'localhost']);

        $this->deleteJson(route('api.delete', ['app_key' => $site->app_key, 'token' => 'invalid-token']))
            ->assertNotFound();
    }
}
