<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Realm;

class KingdomApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_kingdom()
    {
        $realm = Realm::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/kingdoms', $realm
        );

        $this->assertApiResponse($realm);
    }

    /**
     * @test
     */
    public function test_read_kingdom()
    {
        $realm = Realm::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/kingdoms/'.$realm->id
        );

        $this->assertApiResponse($realm->toArray());
    }

    /**
     * @test
     */
    public function test_update_kingdom()
    {
        $realm = Realm::factory()->create();
        $editedKingdom = Realm::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/kingdoms/'.$realm->id,
            $editedKingdom
        );

        $this->assertApiResponse($editedKingdom);
    }

    /**
     * @test
     */
    public function test_delete_kingdom()
    {
        $realm = Realm::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/kingdoms/'.$realm->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/kingdoms/'.$realm->id
        );

        $this->response->assertStatus(404);
    }
}
