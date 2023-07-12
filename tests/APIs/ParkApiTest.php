<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Park;

class ParkApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_park()
    {
        $park = Park::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/parks', $park
        );

        $this->assertApiResponse($park);
    }

    /**
     * @test
     */
    public function test_read_park()
    {
        $park = Park::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/parks/'.$park->id
        );

        $this->assertApiResponse($park->toArray());
    }

    /**
     * @test
     */
    public function test_update_park()
    {
        $park = Park::factory()->create();
        $editedPark = Park::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/parks/'.$park->id,
            $editedPark
        );

        $this->assertApiResponse($editedPark);
    }

    /**
     * @test
     */
    public function test_delete_park()
    {
        $park = Park::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/parks/'.$park->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/parks/'.$park->id
        );

        $this->response->assertStatus(404);
    }
}
