<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Realm;

class RealmApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_realm()
    {
        $realm = Realm::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/realms', $realm
        );

        $this->assertApiResponse($realm);
    }

    /**
     * @test
     */
    public function test_read_realm()
    {
        $realm = Realm::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/realms/'.$realm->id
        );

        $this->assertApiResponse($realm->toArray());
    }

    /**
     * @test
     */
    public function test_update_realm()
    {
        $realm = Realm::factory()->create();
        $editedRealm = Realm::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/realms/'.$realm->id,
            $editedRealm
        );

        $this->assertApiResponse($editedRealm);
    }

    /**
     * @test
     */
    public function test_delete_realm()
    {
        $realm = Realm::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/realms/'.$realm->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/realms/'.$realm->id
        );

        $this->response->assertStatus(404);
    }
}
