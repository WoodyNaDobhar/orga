<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Kingdom;

class KingdomApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_kingdom()
    {
        $kingdom = Kingdom::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/kingdoms', $kingdom
        );

        $this->assertApiResponse($kingdom);
    }

    /**
     * @test
     */
    public function test_read_kingdom()
    {
        $kingdom = Kingdom::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/kingdoms/'.$kingdom->id
        );

        $this->assertApiResponse($kingdom->toArray());
    }

    /**
     * @test
     */
    public function test_update_kingdom()
    {
        $kingdom = Kingdom::factory()->create();
        $editedKingdom = Kingdom::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/kingdoms/'.$kingdom->id,
            $editedKingdom
        );

        $this->assertApiResponse($editedKingdom);
    }

    /**
     * @test
     */
    public function test_delete_kingdom()
    {
        $kingdom = Kingdom::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/kingdoms/'.$kingdom->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/kingdoms/'.$kingdom->id
        );

        $this->response->assertStatus(404);
    }
}
