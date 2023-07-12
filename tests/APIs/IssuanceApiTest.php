<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Issuance;

class IssuanceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_issuance()
    {
        $issuance = Issuance::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/issuances', $issuance
        );

        $this->assertApiResponse($issuance);
    }

    /**
     * @test
     */
    public function test_read_issuance()
    {
        $issuance = Issuance::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/issuances/'.$issuance->id
        );

        $this->assertApiResponse($issuance->toArray());
    }

    /**
     * @test
     */
    public function test_update_issuance()
    {
        $issuance = Issuance::factory()->create();
        $editedIssuance = Issuance::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/issuances/'.$issuance->id,
            $editedIssuance
        );

        $this->assertApiResponse($editedIssuance);
    }

    /**
     * @test
     */
    public function test_delete_issuance()
    {
        $issuance = Issuance::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/issuances/'.$issuance->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/issuances/'.$issuance->id
        );

        $this->response->assertStatus(404);
    }
}
