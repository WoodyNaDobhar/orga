<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\KingdomTitle;

class KingdomTitleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_kingdom_title()
    {
        $kingdomTitle = KingdomTitle::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/kingdom-titles', $kingdomTitle
        );

        $this->assertApiResponse($kingdomTitle);
    }

    /**
     * @test
     */
    public function test_read_kingdom_title()
    {
        $kingdomTitle = KingdomTitle::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/kingdom-titles/'.$kingdomTitle->id
        );

        $this->assertApiResponse($kingdomTitle->toArray());
    }

    /**
     * @test
     */
    public function test_update_kingdom_title()
    {
        $kingdomTitle = KingdomTitle::factory()->create();
        $editedKingdomTitle = KingdomTitle::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/kingdom-titles/'.$kingdomTitle->id,
            $editedKingdomTitle
        );

        $this->assertApiResponse($editedKingdomTitle);
    }

    /**
     * @test
     */
    public function test_delete_kingdom_title()
    {
        $kingdomTitle = KingdomTitle::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/kingdom-titles/'.$kingdomTitle->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/kingdom-titles/'.$kingdomTitle->id
        );

        $this->response->assertStatus(404);
    }
}
