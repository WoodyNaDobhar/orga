<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\KingdomOffice;

class KingdomOfficeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_kingdom_office()
    {
        $kingdomOffice = KingdomOffice::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/kingdom-offices', $kingdomOffice
        );

        $this->assertApiResponse($kingdomOffice);
    }

    /**
     * @test
     */
    public function test_read_kingdom_office()
    {
        $kingdomOffice = KingdomOffice::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/kingdom-offices/'.$kingdomOffice->id
        );

        $this->assertApiResponse($kingdomOffice->toArray());
    }

    /**
     * @test
     */
    public function test_update_kingdom_office()
    {
        $kingdomOffice = KingdomOffice::factory()->create();
        $editedKingdomOffice = KingdomOffice::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/kingdom-offices/'.$kingdomOffice->id,
            $editedKingdomOffice
        );

        $this->assertApiResponse($editedKingdomOffice);
    }

    /**
     * @test
     */
    public function test_delete_kingdom_office()
    {
        $kingdomOffice = KingdomOffice::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/kingdom-offices/'.$kingdomOffice->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/kingdom-offices/'.$kingdomOffice->id
        );

        $this->response->assertStatus(404);
    }
}
